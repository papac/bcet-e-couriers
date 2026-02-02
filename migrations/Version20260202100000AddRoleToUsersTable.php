<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260202100000AddRoleToUsersTable extends Migration
{
    /**
     * Up Migration
     */
    public function up(): void
    {
        $this->alter("users", function (Table $table) {
            $table->addEnum('role', ['size' => ['admin', 'agent'], 'default' => 'agent']);
            $table->addString('phone', ['nullable' => true]);
            $table->addBoolean('is_active', ['default' => true]);
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->alter("users", function (Table $table) {
            $table->dropColumn('role');
            $table->dropColumn('phone');
            $table->dropColumn('is_active');
        });
    }
}
