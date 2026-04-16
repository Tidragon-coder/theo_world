<?php

declare(strict_types=1);

namespace App\Controller;

/**
 * Boardgames Controller
 *
 * @property \App\Model\Table\BoardgamesTable $Boardgames
 */
class BoardgamesController extends AppController
{
    public function index()
    {
        $boardgames = $this->Boardgames->find()->all();
        $currentGames = [];
        $identity = $this->request->getAttribute('identity');
        if ($identity !== null) {
            $usersessiongameTable = $this->fetchTable('Usersessiongame');
            $currentGames = $usersessiongameTable
                ->find()
                ->contain([
                    'Sessiongames' => ['Boardgames'],
                ])
                ->where([
                    'Usersessiongame.user_id' => (int)$identity->getIdentifier(),
                    'Sessiongames.is_finish' => false,
                ])
                ->orderByDesc('Usersessiongame.id')
                ->all()
                ->toList();
        }

        $this->set(compact('boardgames', 'currentGames'));

        $this->viewBuilder()->setTemplatePath('Pages')->setTemplate('home');      
    }
}
