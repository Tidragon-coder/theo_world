<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateMastermindsettings extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/5/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('mastermindsettings');
        $table->addColumn('steps', 'text', [
            'default' => null,
            'null' => false,
        ]);
        $table->addColumn('sessiongames_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->create();
    }
}
