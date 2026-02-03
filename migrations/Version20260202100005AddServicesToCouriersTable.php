<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260202100005AddServicesToCouriersTable extends Migration
{
    /**
     * Up Migration
     */
    public function up(): void
    {
        $this->alter("couriers", function (Table $table) {
            // Origin service (where the courier was received)
            $table->addInteger('origin_service_id', ['nullable' => true]);
            // Destination service (where the courier should be delivered)
            $table->addInteger('destination_service_id', ['nullable' => true]);
            // Current service (where the courier is currently located)
            $table->addInteger('current_service_id', ['nullable' => true]);

            // Courier type: individual (sender/receiver) or service (service-to-service)
            $table->addColumn('courier_type', 'enum', [
                'size' => ['individual', 'service'],
                'default' => 'individual'
            ]);
        });
    }

    /**
     * Rollback migration
     */
    public function rollback(): void
    {
        $this->alter("couriers", function (Table $table) {
            $table->dropColumn('origin_service_id');
            $table->dropColumn('destination_service_id');
            $table->dropColumn('current_service_id');
            $table->dropColumn('courier_type');
        });
    }
}
