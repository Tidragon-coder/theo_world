<?php

namespace App\Controller;

class MastermindsettingsController extends AppController
{
    public function createForSession(int $sessionId)
    {
        $setting = $this->Mastermindsettings->newEmptyEntity();
        $setting->sessiongames_id = $sessionId;
        $setting->steps = json_encode([]); 

        if ($this->Mastermindsettings->save($setting)) {
            $this->Flash->success('Paramètres Mastermind créés.');
            return $this->redirect(['controller' => 'Boardgames', 'action' => 'index']);
        }

        $this->Flash->error('Erreur lors de la création des paramètres.');
        return $this->redirect($this->referer('/'));
    }
}
