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
        Schema::create('FIS_MPM_OUT', function (Blueprint $table) {
          $table->id(); // Primary key
          $table->string('MATNR', 100)->nullable();
          $table->string('TDOBJECT', 100)->nullable();
          $table->string('TDID', 100)->nullable();
          $table->string('TDSPRAS', 100)->nullable();
          $table->string('VKORG', 100)->nullable();
          $table->string('VTWEG', 100)->nullable();
          $table->string('ZEILE', 100)->nullable();
          $table->string('TDFORMAT', 100)->nullable();
          $table->string('TDLINE', 100)->nullable();
          $table->timestamps(); // Created at and Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('FIS_MPM_OUT');
    }
};
