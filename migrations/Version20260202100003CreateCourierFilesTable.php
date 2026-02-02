<?php

use Bow\Database\Migration\Migration;
use Bow\Database\Migration\SQLGenerator;

class Version20260202100003CreateCourierFilesTable extends Migration
{
    /**
     * Create Table
     */
    public function up(): void
    {
        $this->create("courier_files", function (SQLGenerator $table) {
            $table->addIncrement("id");
            $table->addForeign('courier_id', [
                'table' => 'couriers',
                'column' => 'id',
                'on_delete' => 'CASCADE'
            ]);
            $table->addString("filename", 255);
            $table->addString("original_name", 255);
            $table->addString("mime_type", 100);
            $table->addInteger("size")->unsigned();
            $table->addString("path", 500);
            $table->addForeign('uploaded_by', [
                'table' => 'users',
                'column' => 'id',
                'on_delete' => 'SET NULL'
            ])->nullable();
            $table->addTimestamps();
        });
    }

    /**
     * Drop Table
     */
    public function down(): void
    {
        $this->dropIfExists("courier_files");
    }
}
