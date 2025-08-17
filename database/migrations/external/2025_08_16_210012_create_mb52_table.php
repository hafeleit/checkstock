<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'external_mysql';

    public function up(): void
    {
        Schema::connection($this->connection)->create('MB52', function (Blueprint $table) {
            $table->string('material', 20)->nullable();
            $table->string('storage_location', 10)->nullable();
            $table->string('descr_of_storage_loc', 100)->nullable();
            $table->decimal('unrestricted', 15, 2)->default(0)->nullable(); // รองรับตัวเลขใหญ่ + ทศนิยม
            $table->string('special_stock', 5)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('MB52');
    }
};
