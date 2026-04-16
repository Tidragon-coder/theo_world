<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class FillersettingsController extends AppController
{
    public function createForSession(int $sessionId)
    {
        $setting = $this->Fillersettings->newEmptyEntity();
        $setting->sessiongames_id = $sessionId;
        $grid = [];
        for ($i = 0; $i < 64; $i++) {
            $grid[] = rand(1, 5);
        }
        $setting->grid = json_encode($grid);

        if ($this->Fillersettings->save($setting)) {
            $this->Flash->success('Parametres Filler crees.');

            return $this->redirect(['action' => 'play', $sessionId]);
        }

        $this->Flash->error('Erreur lors de la creation des parametres.');

        return $this->redirect($this->referer('/'));
    }

    public function play(int $sessionId)
    {
        $setting = $this->Fillersettings
            ->find()
            ->contain(['Sessiongames'])
            ->where(['sessiongames_id' => $sessionId])
            ->first();

        if ($setting === null) {
            throw new NotFoundException('Parametres introuvables pour cette session.');
        }

        $grid = json_decode((string)$setting->grid, true);
        if (!is_array($grid)) {
            $grid = [];
        }

        // Fetch players for this session and determine current user's player number if any
        $usersessiongameTable = $this->getTableLocator()->get('Usersessiongame');
        $players = $usersessiongameTable->find()
            ->where(['sessiongame_id' => $sessionId])
            ->contain(['Users'])
            ->order(['Usersessiongame.player_number' => 'ASC', 'Usersessiongame.created' => 'ASC'])
            ->all();

        $playerNumber = null;
        $identity = $this->request->getAttribute('identity');
        if ($identity !== null) {
            $userId = (int)$identity->getIdentifier();
            $me = $players->filter(function($p) use ($userId) { return (int)$p->user_id === $userId; })->first();
            if ($me) {
                $playerNumber = $me->player_number ?? null;
            }
        }

        $this->set(compact('setting', 'grid', 'sessionId', 'players', 'playerNumber'));
    }

    public function setPlayerColor(int $sessionId)
    {
        $this->request->allowMethod(['post']);

        $identity = $this->request->getAttribute('identity');
        if ($identity === null) {
            $this->set(['success' => false, 'message' => 'Vous devez être connecté.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        $userId = (int)$identity->getIdentifier();
        $usersessiongameTable = $this->getTableLocator()->get('Usersessiongame');
        $playerRow = $usersessiongameTable->find()->where(['sessiongame_id' => $sessionId, 'user_id' => $userId])->first();
        if (!$playerRow) {
            $this->set(['success' => false, 'message' => 'Vous ne participez pas à cette session.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        $playerNumber = (int)($playerRow->player_number ?? 0);
        if ($playerNumber !== 1 && $playerNumber !== 2) {
            $this->set(['success' => false, 'message' => 'Numéro de joueur invalide.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        $data = $this->request->getData();
        $colorNum = isset($data['color']) ? (int)$data['color'] : null;
        if ($colorNum === null || $colorNum < 1) {
            $this->set(['success' => false, 'message' => 'Couleur invalide.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        $setting = $this->Fillersettings->find()->where(['sessiongames_id' => $sessionId])->first();
        if (!$setting) {
            $this->set(['success' => false, 'message' => 'Parametres introuvables.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        $grid = json_decode((string)$setting->grid, true);
        if (!is_array($grid) || count($grid) !== 64) {
            $this->set(['success' => false, 'message' => 'Grille invalide.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        $firstKey = array_key_first($grid);
        $lastKey = array_key_last($grid);
        $refIndex = ($playerNumber === 2) ? $firstKey : $lastKey;

        if ($refIndex === null) {
            $this->set(['success' => false, 'message' => 'Référence de joueur introuvable.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        // compute neighbors
        $row = intdiv($refIndex, 8);
        $col = $refIndex % 8;
        $neighbors = [];
        if ($row > 0) $neighbors[] = $refIndex - 8;
        if ($row < 7) $neighbors[] = $refIndex + 8;
        if ($col > 0) $neighbors[] = $refIndex - 1;
        if ($col < 7) $neighbors[] = $refIndex + 1;

        // exclude J2's color
        $j2ColorNum = null;
        if ($firstKey !== null && isset($grid[$firstKey])) {
            $j2ColorNum = (int)$grid[$firstKey];
        }

        $found = false;
        foreach ($neighbors as $n) {
            if (isset($grid[$n]) && (int)$grid[$n] === $colorNum) { $found = true; break; }
        }

        if (!$found || ($j2ColorNum !== null && $colorNum === $j2ColorNum)) {
            $this->set(['success' => false, 'message' => 'Couleur non disponible autour de vous.']);
            $this->viewBuilder()->setOption('serialize', ['success','message']);
            return;
        }

        // update reference cell color
        $grid[$refIndex] = $colorNum;
        $setting->grid = json_encode($grid);

        if ($this->Fillersettings->save($setting)) {
            $this->set(['success' => true, 'color' => $colorNum, 'refIndex' => $refIndex]);
            $this->viewBuilder()->setOption('serialize', ['success','color','refIndex']);
            return;
        }

        $this->set(['success' => false, 'message' => 'Impossible de sauvegarder la couleur.']);
        $this->viewBuilder()->setOption('serialize', ['success','message']);
    }

}
