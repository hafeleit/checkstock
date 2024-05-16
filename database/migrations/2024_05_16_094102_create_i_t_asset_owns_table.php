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
        Schema::create('i_t_asset_owns', function (Blueprint $table) {
          $table->id();
          $table->string('computer_name');
          $table->string('user');
          $table->string('main')->default('N');
          $table->integer('status')->default(0);
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_t_asset_owns');
    }
};
