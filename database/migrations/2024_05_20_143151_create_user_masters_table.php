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
        Schema::create('user_masters', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->nullable();
            $table->string('job_code')->nullable();
            $table->string('name_en')->nullable();
            $table->string('name_th')->nullable();
            $table->string('dept')->nullable();
            $table->string('position')->nullable();
            $table->string('location')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_masters');
    }
};
