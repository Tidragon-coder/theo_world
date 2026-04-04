<?php

declare(strict_types=1);

use Migrations\BaseMigration;

class AddTimestampsToGamesTables extends BaseMigration
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
        foreach (['boardgames', 'sessiongames', 'mastermindsettings', 'fillersettings', 'usersessiongame'] as $tableName) {
            $table = $this->table($tableName);
            $table
                ->addColumn('created', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->addColumn('modified', 'datetime', ['null' => false, 'default' => 'CURRENT_TIMESTAMP'])
                ->update();
        }
    }
}
