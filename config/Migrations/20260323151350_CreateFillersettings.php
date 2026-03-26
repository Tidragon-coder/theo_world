<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateFillersettings extends BaseMigration
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
        $table = $this->table('fillersettings');
        $table->addColumn('nb_colonne', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->addColumn('grid', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('sessiongames_id', 'integer', [
            'default' => null,
            'limit' => 11,
            'null' => false,
        ]);
        $table->create();
    }
}
