<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'external_mysql';

    public function up(): void
    {
        Schema::connection($this->connection)->create('ZHWWBCQUERYDIR', function (Blueprint $table) {
            $table->string('Material', 20)->nullable();
            $table->string('kurztext', 255)->nullable();
            $table->string('bun', 50)->nullable();
            $table->string('Numer', 50)->nullable();
            $table->string('aun', 50)->nullable();
            $table->string('dm', 50)->nullable();
            $table->string('lage', 50)->nullable();
            $table->string('mov_avg_price', 50)->nullable();
            $table->string('gross_weight', 50)->nullable();
            $table->string('wun', 50)->nullable();
            $table->string('volume', 50)->nullable();
            $table->string('vun', 50)->nullable();
            $table->string('per', 50)->nullable();
            $table->string('pgr', 50)->nullable();
            $table->string('product_group_manager', 50)->nullable();
            $table->string('follow_up_material', 50)->nullable();
            $table->string('war', 50)->nullable();
            $table->string('st', 50)->nullable();
            $table->string('vertriebss', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('ZHWWBCQUERYDIR');
    }
};
