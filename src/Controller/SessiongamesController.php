<?php
declare(strict_types=1);

namespace App\Controller;

class SessiongamesController extends AppController
{
    public function createFromGame(int $gameId)
    {
        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            $this->Flash->error('Vous devez etre connecte pour demarrer une partie.');

            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

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
        $usersessiongame->user_id = (int)$identity->getIdentifier();
        $usersessiongame->sessiongame_id = (int)$session->id;

        if (!$usersessiongameTable->save($usersessiongame)) {
            $this->Sessiongames->delete($session);
            $this->Flash->error('Impossible d associer la session a votre compte.');

            return $this->redirect($this->referer('/'));
        }

        return $this->redirect(['controller' => 'Mastermindsettings', 'action' => 'createForSession', $session->id]);
    }
}
