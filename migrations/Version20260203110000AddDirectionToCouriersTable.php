<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260203110000AddDirectionToCouriersTable extends Migration
{
    /**
     * Up migration
     *
     * @return void
     */
    public function up(): void
    {
        $this->alter('couriers', function (Table $table): void {
            $table->addString('direction', ['default' => 'incoming']); // incoming or outgoing
        });
    }

    /**
     * Rollback migration
     *
     * @return void
     */
    public function rollback(): void
    {
        $this->alter('couriers', function (Table $table): void {
            $table->dropColumn('direction');
        });
    }
}
