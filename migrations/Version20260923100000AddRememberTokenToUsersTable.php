<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260923100000AddRememberTokenToUsersTable extends Migration
{
    /**
     * Up Migration - Add remember token used by the session guard
     */
    public function up(): void
    {
        $this->alter("users", function (Table $table) {
            $table->addString('remember_token', ['nullable' => true, 'size' => 100]);
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->alter("users", function (Table $table) {
            $table->dropColumn('remember_token');
        });
    }
}
