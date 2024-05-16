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
        Schema::create('i_t_asset_specs', function (Blueprint $table) {
          $table->id();
          $table->string('computer_name');
          $table->string('cpu')->nullable();
          $table->string('ram')->nullable();
          $table->string('storage')->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_t_asset_specs');
    }
};
