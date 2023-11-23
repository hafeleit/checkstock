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
        Schema::create('OW_LAST12MON_T20_CUST_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('LT_COMP_CODE');
            $table->string('LT_CUST_CODE');
            $table->string('LT_CUST_NAME');
            $table->string('LT_ITEM_CODE');
            $table->string('LT_GRADE_CODE_1');
            $table->string('LT_GRADE_CODE_2');
            $table->string('LT_INV_COUNT');
            $table->string('LT_ORD_QTY_BU');
            $table->string('LT_ORD_QTY');
            $table->string('LT_ORD_QTY_LS');
            $table->string('LT_ORD_VAL');
            $table->string('LT_GC_PERC');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_LAST12MON_T20_CUST_WEB_HAFL');
    }
};
