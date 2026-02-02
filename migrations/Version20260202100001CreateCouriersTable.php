<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260202100001CreateCouriersTable extends Migration
{
    /**
     * Up Migration
     */
    public function up(): void
    {
        $this->create("couriers", function (Table $table) {
            $table->addIncrement('id');
            $table->addString('tracking_number', ['unique' => true]);
            
            // Sender information
            $table->addString('sender_name');
            $table->addString('sender_phone');
            $table->addText('sender_address');
            
            // Receiver information
            $table->addString('receiver_name');
            $table->addString('receiver_phone');
            $table->addText('receiver_address');
            
            // Package details
            $table->addString('description', ['nullable' => true]);
            $table->addFloat('weight', ['nullable' => true]);
            $table->addFloat('price', ['nullable' => true]);
            
            // Status
            $table->addEnum('status', ['size' => ['pending', 'received', 'in_transit', 'delivered', 'returned'], 'default' => 'pending']);
            
            // Relations
            $table->addForeign('agent_id', [
                'table' => 'users',
                'column' => 'id',
                'onDelete' => 'CASCADE'
            ]);
            
            $table->addString('notes', ['nullable' => true]);
            $table->addTimestamps();
            
            $table->withEngine('InnoDB');
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->dropIfExists("couriers");
    }
}
