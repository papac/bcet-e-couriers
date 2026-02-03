<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260202100006AddServiceToUsersTable extends Migration
{
    /**
     * Up Migration - Link agents to their service/branch
     */
    public function up(): void
    {
        $this->alter("users", function (Table $table) {
            $table->addInteger('service_id', ['nullable' => true]);
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->alter("users", function (Table $table) {
            $table->dropColumn('service_id');
        });
    }
}
