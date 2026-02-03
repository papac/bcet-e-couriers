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
            $table->addInteger('agent_id', ['nullable' => true]);
            $table->addString('sender_name');
            $table->addString('sender_phone');
            $table->addText('sender_address');
            $table->addString('receiver_name');
            $table->addString('receiver_phone');
            $table->addText('receiver_address');
            $table->addString('description', ['nullable' => true]);
            $table->addDouble('weight', ['nullable' => true]);
            $table->addDouble('price', ['nullable' => true]);
            $table->addColumn('status', 'enum', [
                'size' => ['pending', 'received', 'in_transit', 'delivered', 'returned'],
                'default' => 'pending'
            ]);
            $table->addString('notes', ['nullable' => true]);
            $table->addForeign('agent_id', [
                'table' => 'users',
                'references' => 'id',
                'on' => 'delete set null',
            ]);
            $table->addTimestamps();
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
