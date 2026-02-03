<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260202100002CreateCourierStatusHistoryTable extends Migration
{
    /**
     * Up Migration
     */
    public function up(): void
    {
        $this->create("courier_status_history", function (Table $table) {
            $table->addBigIncrement('id');
            $table->addInteger('courier_id', ['nullable' => true]);
            $table->addInteger('changed_by', ['nullable' => true]);
            $table->addColumn('old_status', 'enum', ['size' => ['pending', 'received', 'in_transit', 'delivered', 'returned'], 'nullable' => true]);
            $table->addColumn('new_status', 'enum', ['size' => ['pending', 'received', 'in_transit', 'delivered', 'returned']]);
            $table->addText('comment', ['nullable' => true]);
            $table->addForeign('courier_id', [
                'table' => 'couriers',
                'references' => 'id',
                'on' => 'delete cascade'
            ]);
            $table->addForeign('changed_by', [
                'table' => 'users',
                'references' => 'id',
                'on' => 'delete set null',
                'nullable' => true
            ]);
            $table->addTimestamps();
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->dropIfExists("courier_status_history");
    }
}
