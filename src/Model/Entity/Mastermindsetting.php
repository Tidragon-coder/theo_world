<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Mastermindsetting Entity
 *
 * @property int $id
 * @property string $steps
 * @property int $sessiongames_id
 * @property \Cake\I18n\DateTime $created
 * @property \Cake\I18n\DateTime $modified
 *
 * @property \App\Model\Entity\Sessiongame $sessiongame
 */
class Mastermindsetting extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected array $_accessible = [
        'steps' => true,
        'sessiongames_id' => true,
        'created' => true,
        'modified' => true,
        'sessiongame' => true,
    ];
}
