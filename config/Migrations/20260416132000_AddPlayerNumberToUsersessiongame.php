<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class AddPlayerNumberToUsersessiongame extends BaseMigration
{
    public function change(): void
    {
        $table = $this->table('usersessiongame');

        // Add player_number column (nullable initially)
        if (!$table->hasColumn('player_number')) {
            $table->addColumn('player_number', 'integer', [
                'null' => true,
                'default' => null,
                'limit' => 1,
            ]);
        }

        // Add unique index to prevent two players with same slot in a session
        if (!$table->hasIndex('ux_session_player')) {
            $table->addIndex(['sessiongame_id', 'player_number'], ['unique' => true, 'name' => 'ux_session_player']);
        }

        // Ensure (sessiongame_id, user_id) unique to avoid duplicates
        if (!$table->hasIndex('ux_session_user')) {
            $table->addIndex(['sessiongame_id', 'user_id'], ['unique' => true, 'name' => 'ux_session_user']);
        }

        $table->update();
    }
}
