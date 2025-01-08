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
        Schema::table('product_new_price_lists', function (Blueprint $table) {
            $table->float('USD_PRICE')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_new_price_lists', function (Blueprint $table) {
            $table->dropcolumn('USD_PRICE');
        });
    }
};
