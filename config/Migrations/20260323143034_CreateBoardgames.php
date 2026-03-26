<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateBoardgames extends BaseMigration
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
        $table = $this->table('boardgames');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 50,
            'null' => false,
        ]);
        $table->addColumn('description', 'text', [
            'default' => null,
            'limit' => 200,
            'null' => true,
        ]);
        $table->addColumn('picture', 'string', [
            'default' => null,
            'limit' => 80,
            'null' => true,
        ]);
        $table->create();
    }
}
