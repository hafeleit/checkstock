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
        Schema::table('product_items', function (Blueprint $table) {
          $table->string('country_code',50)->nullable()->change();
          $table->string('max_power_of_lamp',30)->nullable()->change();
          $table->string('format',200)->nullable()->change();
          $table->string('made_by',200)->change();
          $table->string('model',200)->nullable()->change();
          $table->string('product_name',200)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_items', function (Blueprint $table) {
            $table->string('country_code',10)->nullable()->change();
            $table->integer('max_power_of_lamp')->nullable()->change();
            $table->string('format',50)->nullable()->change();
            $table->string('made_by',30)->change();
            $table->string('model',50)->nullable()->change();
            $table->string('product_name',50)->change();
        });
    }
};
