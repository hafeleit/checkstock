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
        Schema::create('OW_LAST3MON_T20_CUST_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('LTC_COMP_CODE');
            $table->string('LTC_CUST_CODE');
            $table->string('LTC_CUST_NAME');
            $table->string('LTC_ITEM_CODE');
            $table->string('LTC_GRADE_CODE_1');
            $table->string('LTC_GRADE_CODE_2');
            $table->string('LTC_INV_COUNT');
            $table->string('LTC_ORD_QTY_BU');
            $table->string('LTC_ORD_QTY');
            $table->string('LTC_ORD_QTY_LS');
            $table->string('LTC_ORD_VAL');
            $table->string('LTC_GC_PERC');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_LAST3MON_T20_CUST_WEB_HAFL');
    }
};
