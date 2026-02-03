<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\Table;

class Version20260202100003CreateCourierFilesTable extends Migration
{
    /**
     * Create Table
     */
    public function up(): void
    {
        $this->create("courier_files", function (Table $table) {
            $table->addBigIncrement("id");
            $table->addInteger("courier_id");
            $table->addString("filename", ['size' => 255]);
            $table->addString("original_name", ['size' => 255]);
            $table->addString("mime_type", ['size' => 100]);
            $table->addInteger("size");
            $table->addString("path", ['size' => 500]);
            $table->addForeign('courier_id', [
                'table' => 'couriers',
                'references' => 'id',
                'on' => 'delete cascade'
            ]);
            $table->addTimestamps();
            $table->withEngine('InnoDB');
        });
    }

    /**
     * Drop Table
     */
    public function rollback(): void
    {
        $this->dropIfExists("courier_files");
    }
}
