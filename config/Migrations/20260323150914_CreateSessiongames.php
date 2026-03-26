<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateSessiongames extends BaseMigration
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
        $table = $this->table('sessiongames');
        $table->addColumn('Boardgames_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('is_finish', 'boolean', [
            'default' => false,
            'null' => false,
        ]);
        $table->addColumn('code', 'string', [
            'default' => null,
            'limit' => 7,
            'null' => true,
        ]);
        $table->create();
    }
}
