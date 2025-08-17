<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'external_mysql';

    public function up(): void
    {
        Schema::connection($this->connection)->create('ZORDPOSKONV_ZPL', function (Blueprint $table) {
            $table->string('Material', 20)->nullable();
            $table->decimal('Amount', 20, 2)->nullable(); // รองรับเลขใหญ่และทศนิยม
            $table->string('per', 10)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('ZORDPOSKONV_ZPL');
    }
};
