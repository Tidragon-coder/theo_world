<?php
declare(strict_types=1);

namespace App\Controller;

class SessiongamesController extends AppController
{
    public function myCurrentGames()
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            $this->Flash->error('Vous devez etre connecte pour voir vos parties.');

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $userId = (int)$identity->getIdentifier();
        $usersessiongameTable = $this->fetchTable('Usersessiongame');

        $entries = $usersessiongameTable
            ->find()
            ->contain([
                'Sessiongames' => ['Boardgames'],
            ])
            ->where([
                'Usersessiongame.user_id' => $userId,
                'Sessiongames.is_finish' => false,
            ])
            ->orderByDesc('Usersessiongame.id')
            ->all();

        $this->set(compact('entries'));
    }

    public function createFromGame(int $gameId)
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            $this->Flash->error('Vous devez etre connecte pour demarrer une partie.');

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $userId = (int)$identity->getIdentifier();

        // Determine boardgame name early to decide join/create strategy
        $boardgamesTable = $this->getTableLocator()->get('Boardgames');
        try {
            $boardgame = $boardgamesTable->get($gameId);
            $gameName = strtolower((string)($boardgame->name ?? ''));
        } catch (\Exception $e) {
            $gameName = '';
        }

        // For filler: try to join an existing session with exactly 1 player (oldest)
        if ($gameName === 'filler') {
            $usersessiongameTable = $this->fetchTable('Usersessiongame');

            $session = $this->Sessiongames->find()
                ->select(['Sessiongames.id', 'Sessiongames.Boardgames_id', 'Sessiongames.is_finish', 'Sessiongames.code', 'Sessiongames.created'])
                ->matching('Usersessiongame')
                ->where(['Sessiongames.Boardgames_id' => $gameId, 'Sessiongames.is_finish' => false])
                ->group(['Sessiongames.id'])
                ->having(['COUNT(Usersessiongame.id) =' => 1])
                ->orderAsc('Sessiongames.created')
                ->first();

            if ($session) {
                // ensure user not already in session
                $exists = $usersessiongameTable->exists(['sessiongame_id' => $session->id, 'user_id' => $userId]);
                if (!$exists) {
                    // compute next available player slot (1 or 2)
                    $countPlayers = (int)$usersessiongameTable->find()->where(['sessiongame_id' => $session->id])->count();
                    $playerNumber = ($countPlayers < 2) ? ($countPlayers + 1) : null;

                    $usersessiongame = $usersessiongameTable->newEmptyEntity();
                    $usersessiongame->user_id = $userId;
                    $usersessiongame->sessiongame_id = (int)$session->id;
                    if ($playerNumber !== null) {
                        $usersessiongame->player_number = $playerNumber;
                    }

                    if (!$usersessiongameTable->save($usersessiongame)) {
                        $this->Flash->error('Impossible de rejoindre la session.');

                        return $this->redirect($this->referer('/'));
                    }
                }

                return $this->redirect(['controller' => 'Fillersettings', 'action' => 'play', $session->id]);
            }
            // else: no joinable session found; fallthrough to create a new one
        }

        // Create a new session (existing behaviour)
        $session = $this->Sessiongames->newEmptyEntity();
        $session->Boardgames_id = $gameId;
        $session->is_finish = false;
        $session->code = strtoupper(substr(bin2hex(random_bytes(4)), 0, 6));

        if (!$this->Sessiongames->save($session)) {
            $this->Flash->error('Impossible de creer la session.');

            return $this->redirect($this->referer('/'));
        }

        $usersessiongameTable = $this->fetchTable('Usersessiongame');
        $usersessiongame = $usersessiongameTable->newEmptyEntity();
        $usersessiongame->user_id = $userId;
        $usersessiongame->sessiongame_id = (int)$session->id;

        // assign player_number = 1 for the creator/new session
        $usersessiongame->player_number = 1;

        if (!$usersessiongameTable->save($usersessiongame)) {
            $this->Sessiongames->delete($session);
            $this->Flash->error('Impossible d associer la session a votre compte.');

            return $this->redirect($this->referer('/'));
        }

        if ($gameName === 'filler') {
            return $this->redirect(['controller' => 'Fillersettings', 'action' => 'createForSession', $session->id]);
        }

        return $this->redirect(['controller' => 'Mastermindsettings', 'action' => 'createForSession', $session->id]);
    }
}
