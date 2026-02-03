<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260202100004CreateServicesTable extends Migration
{
    /**
     * Up Migration
     */
    public function up(): void
    {
        $this->create("services", function (Table $table) {
            $table->addIncrement('id');
            $table->addString('name');
            $table->addString('code', ['unique' => true, 'size' => 20]);
            $table->addString('address', ['nullable' => true]);
            $table->addString('city', ['nullable' => true]);
            $table->addString('phone', ['nullable' => true]);
            $table->addString('email', ['nullable' => true]);
            $table->addInteger('chief_id', ['nullable' => true]);
            $table->addBoolean('is_active', ['default' => true]);
            $table->addTimestamps();

            $table->addForeign('chief_id', [
                'table' => 'users',
                'references' => 'id',
                'on' => 'delete set null'
            ]);
            $table->withEngine('InnoDB');
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->dropIfExists("services");
    }
}
