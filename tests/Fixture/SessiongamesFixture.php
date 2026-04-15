<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SessiongamesFixture
 */
class SessiongamesFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'Boardgames_id' => 1,
                'is_finish' => 1,
                'code' => 'Lorem',
                'created' => '2026-04-04 12:22:46',
                'modified' => '2026-04-04 12:22:46',
            ],
        ];
        parent::init();
    }
}
