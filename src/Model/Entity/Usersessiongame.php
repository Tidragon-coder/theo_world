<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

class Usersessiongame extends Entity
{
    protected array $_accessible = [
        'user_id' => true,
        'sessiongame_id' => true,
        'finalscore' => true,
        'timesession' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
        'sessiongame' => true,
    ];
}
