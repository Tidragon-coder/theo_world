<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsersessiongame extends BaseMigration
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
        $table = $this->table('usersessiongame');
        $table->addColumn('user_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('sessiongame_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('finalscore', 'biginteger', [
            'default' => null,
            'limit' => 20,
            'null' => true,
        ]);
        $table->addColumn('timesession', 'time', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
