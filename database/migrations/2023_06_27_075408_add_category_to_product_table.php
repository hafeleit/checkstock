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
        Schema::table('products', function (Blueprint $table) {
            $table->string('ITEM_NAME_TH')->nullable();
            $table->string('ITEM_BRAND')->nullable();
            $table->string('ITEM_GRADE_CODE_2')->nullable();
            $table->string('PRODUCT_CATEGORY')->nullable();
            $table->string('PRODUCT_GROUP')->nullable();
            $table->string('PRODUCT_AIS')->nullable();
            $table->string('SAI_SA_SUPP_CODE')->nullable();
            $table->string('PURCHASER_NAME')->nullable();
            $table->string('PM_NAME')->nullable();
            $table->string('SALES_CATEGORY')->nullable();
            $table->string('PRICE_LIST_UOM')->nullable();
            $table->string('PACK_CONV_FACTOR')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
