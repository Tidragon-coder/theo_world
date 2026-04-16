<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\NotFoundException;

class MastermindsettingsController extends AppController
{
    public function createForSession(int $sessionId)
    {
        $setting = $this->Mastermindsettings->newEmptyEntity();
        $setting->sessiongames_id = $sessionId;
        $setting->steps = json_encode([[rand(1, 8), rand(1, 8), rand(1, 8), rand(1, 8)]]);

        if ($this->Mastermindsettings->save($setting)) {
            $this->Flash->success('Parametres Mastermind crees.');

            return $this->redirect(['action' => 'play', $sessionId]);
        }

        $this->Flash->error('Erreur lors de la creation des parametres.');

        return $this->redirect($this->referer('/'));
    }

    public function play(int $sessionId)
    {
        $setting = $this->Mastermindsettings
            ->find()
            ->contain(['Sessiongames'])
            ->where(['sessiongames_id' => $sessionId])
            ->first();

        if ($setting === null) {
            throw new NotFoundException('Parametres introuvables pour cette session.');
        }

        $steps = json_decode((string)$setting->steps, true);
        if (!is_array($steps)) {
            $steps = [];
        }

        $this->set(compact('setting', 'steps', 'sessionId'));
    }

    public function addStep(int $sessionId)
    {
        $this->request->allowMethod(['post']);

        $values = [
            (int)$this->request->getData('c1'),
            (int)$this->request->getData('c2'),
            (int)$this->request->getData('c3'),
            (int)$this->request->getData('c4'),
        ];

        foreach ($values as $v) {
            if ($v < 1 || $v > 8) {
                $this->Flash->error('Valeurs invalides.');
                return $this->redirect(['action' => 'play', $sessionId]);
            }
        }

        $setting = $this->Mastermindsettings
            ->find()
            ->where(['sessiongames_id' => $sessionId])
            ->firstOrFail();

        $steps = json_decode((string)$setting->steps, true);
        if (!is_array($steps)) {
            $steps = [];
        }

        // Legacy support: convert flat format [1,2,3,4] to [[1,2,3,4]]
        if ($steps !== [] && isset($steps[0]) && !is_array($steps[0])) {
            $steps = [$steps];
        }

        // Determine current number of guesses (exclude first line if it's the secret code)
        if ($steps !== [] && isset($steps[0]) && is_array($steps[0])) {
            $currentGuesses = max(0, count($steps) - 1);
        } else {
            $currentGuesses = count($steps);
        }

        $maxAttempts = 10;
        if ($currentGuesses >= $maxAttempts) {
            $this->Flash->error('Nombre maximum d\'essais atteint.');
            // mark session finished to hide form in UI
            $sessionTable = $this->getTableLocator()->get('Sessiongames');
            try {
                $session = $sessionTable->get($sessionId);
                $session->is_finish = true;
                $sessionTable->save($session);
            } catch (\Exception $e) {
                // ignore or log
            }
            return $this->redirect(['action' => 'play', $sessionId]);
        }

        $steps[] = $values;
        $setting->steps = json_encode($steps);

        if ($this->Mastermindsettings->save($setting)) {
            // Si la combinaison envoyée correspond exactement au code (première ligne), marquer la session comme finie.
            if (isset($steps[0]) && is_array($steps[0]) && count($steps[0]) === 4) {
                $firstCode = array_map('intval', $steps[0]);
                $guess = array_map('intval', $values);
                if ($firstCode === $guess) {
                    $sessionTable = $this->getTableLocator()->get('Sessiongames');
                    try {
                        $session = $sessionTable->get($sessionId);
                        $session->is_finish = true;
                        if (!$sessionTable->save($session)) {
                            $this->Flash->error('Impossible de marquer la session comme terminée.');
                        }
                    } catch (\Exception $e) {
                        // ignore or log - avoid breaking user flow
                        $this->Flash->error('Erreur lors de la mise à jour de la session.');
                    }
                }
            }

            // After saving, if we've reached max attempts, mark finished
            if ($currentGuesses + 1 >= $maxAttempts) {
                $sessionTable = $this->getTableLocator()->get('Sessiongames');
                try {
                    $session = $sessionTable->get($sessionId);
                    $session->is_finish = true;
                    $sessionTable->save($session);
                    $this->Flash->info('Nombre maximum d\'essais atteint. Partie terminée.');
                } catch (\Exception $e) {
                    // ignore or log
                }
            }
        } else {
            $this->Flash->error('Impossible d enregistrer l essai.');
        }

        return $this->redirect(['action' => 'play', $sessionId]);
    }
}
