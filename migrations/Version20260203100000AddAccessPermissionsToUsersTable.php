<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260203100000AddAccessPermissionsToUsersTable extends Migration
{
    /**
     * Up Migration - Add app access field to users
     */
    public function up(): void
    {
        $this->alter("users", function (Table $table) {
            // App access - stores comma-separated app names (e.g., 'courrier', 'courrier,other_app')
            $table->addString('app_access', ['default' => 'courrier']);
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->alter("users", function (Table $table) {
            $table->dropColumn('app_access');
        });
    }
}
