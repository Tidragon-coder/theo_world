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
        $this->set(compact('boardgames'));

        $this->viewBuilder()->setTemplatePath('Pages')->setTemplate('home');      
    }
}
