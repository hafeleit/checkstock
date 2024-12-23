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
        Schema::create('cml_country_codes', function (Blueprint $table) {
          $table->id();
          $table->string('country_code', 5);
          $table->string('country_description', 156);
          $table->string('country_name_in_thai', 132);
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cml_country_codes');
    }
};
