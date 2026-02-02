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
            $table->addIncrement('id');
            
            $table->addForeign('courier_id', [
                'table' => 'couriers',
                'column' => 'id',
                'onDelete' => 'CASCADE'
            ]);
            
            $table->addForeign('changed_by', [
                'table' => 'users',
                'column' => 'id',
                'onDelete' => 'SET NULL',
                'nullable' => true
            ]);
            
            $table->addEnum('old_status', ["size" => ['pending', 'received', 'in_transit', 'delivered', 'returned'], 'nullable' => true]);
            $table->addEnum('new_status', ['pending', 'received', 'in_transit', 'delivered', 'returned']);
            $table->addText('comment', ['nullable' => true]);

            $table->addTimestamps();
            $table->withEngine('InnoDB');
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
