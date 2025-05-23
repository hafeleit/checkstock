<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inv_record_details', function (Blueprint $table) {
            $table->id();
            $table->string('inv_record_id',14);
            $table->string('inv_number');
            $table->string('status', 50);
            $table->integer('approve')->nullable();
            $table->string('approval',150)->nullable();
            $table->date('approve_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_record_details');
    }
};
