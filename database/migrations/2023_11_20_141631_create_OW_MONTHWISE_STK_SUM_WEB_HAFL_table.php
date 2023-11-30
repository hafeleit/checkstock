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
        Schema::create('OW_MONTHWISE_STK_SUM_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('MSS_COMP_CODE');
            $table->string('MSS_ITEM_CODE');
            $table->string('MSS_GRADE_CODE_1');
            $table->string('MSS_GRADE_CODE_2');
            $table->integer('MSS_TOT_QTY_01');
            $table->integer('MSS_TOT_QTY_LS_01');
            $table->integer('MSS_TOT_QTY_02');
            $table->integer('MSS_TOT_QTY_LS_02');
            $table->integer('MSS_TOT_QTY_03');
            $table->integer('MSS_TOT_QTY_LS_03');
            $table->integer('MSS_TOT_QTY_04');
            $table->integer('MSS_TOT_QTY_LS_04');
            $table->integer('MSS_TOT_QTY_05');
            $table->integer('MSS_TOT_QTY_LS_05');
            $table->integer('MSS_TOT_QTY_06');
            $table->integer('MSS_TOT_QTY_LS_06');
            $table->integer('MSS_TOT_QTY_07');
            $table->integer('MSS_TOT_QTY_LS_07');
            $table->integer('MSS_TOT_QTY_08');
            $table->integer('MSS_TOT_QTY_LS_08');
            $table->integer('MSS_TOT_QTY_09');
            $table->integer('MSS_TOT_QTY_LS_09');
            $table->integer('MSS_TOT_QTY_10');
            $table->integer('MSS_TOT_QTY_LS_10');
            $table->integer('MSS_TOT_QTY_11');
            $table->integer('MSS_TOT_QTY_LS_11');
            $table->integer('MSS_TOT_QTY_12');
            $table->integer('MSS_TOT_QTY_LS_12');
            $table->integer('MSS_TOT_QTY_13');
            $table->integer('MSS_TOT_QTY_LS_13');
            $table->integer('MSS_SOLD_QTY_01');
            $table->integer('MSS_SOLD_QTY_LS_01');
            $table->integer('MSS_SOLD_QTY_02');
            $table->integer('MSS_SOLD_QTY_LS_02');
            $table->integer('MSS_SOLD_QTY_03');
            $table->integer('MSS_SOLD_QTY_LS_03');
            $table->integer('MSS_SOLD_QTY_04');
            $table->integer('MSS_SOLD_QTY_LS_04');
            $table->integer('MSS_SOLD_QTY_05');
            $table->integer('MSS_SOLD_QTY_LS_05');
            $table->integer('MSS_SOLD_QTY_06');
            $table->integer('MSS_SOLD_QTY_LS_06');
            $table->integer('MSS_SOLD_QTY_07');
            $table->integer('MSS_SOLD_QTY_LS_07');
            $table->integer('MSS_SOLD_QTY_08');
            $table->integer('MSS_SOLD_QTY_LS_08');
            $table->integer('MSS_SOLD_QTY_09');
            $table->integer('MSS_SOLD_QTY_LS_09');
            $table->integer('MSS_SOLD_QTY_10');
            $table->integer('MSS_SOLD_QTY_LS_10');
            $table->integer('MSS_SOLD_QTY_11');
            $table->integer('MSS_SOLD_QTY_LS_11');
            $table->integer('MSS_SOLD_QTY_12');
            $table->integer('MSS_SOLD_QTY_LS_12');
            $table->integer('MSS_SOLD_QTY_13');
            $table->integer('MSS_SOLD_QTY_LS_13');
            $table->string('MSS_INV_COUNT_01');
            $table->string('MSS_INV_COUNT_02');
            $table->string('MSS_INV_COUNT_03');
            $table->string('MSS_INV_COUNT_04');
            $table->string('MSS_INV_COUNT_05');
            $table->string('MSS_INV_COUNT_06');
            $table->string('MSS_INV_COUNT_07');
            $table->string('MSS_INV_COUNT_08');
            $table->string('MSS_INV_COUNT_09');
            $table->string('MSS_INV_COUNT_10');
            $table->string('MSS_INV_COUNT_11');
            $table->string('MSS_INV_COUNT_12');
            $table->string('MSS_INV_COUNT_13');
            $table->integer('MSS_CUST_COUNT_01');
            $table->integer('MSS_CUST_COUNT_02');
            $table->integer('MSS_CUST_COUNT_03');
            $table->integer('MSS_CUST_COUNT_04');
            $table->integer('MSS_CUST_COUNT_05');
            $table->integer('MSS_CUST_COUNT_06');
            $table->integer('MSS_CUST_COUNT_07');
            $table->integer('MSS_CUST_COUNT_08');
            $table->integer('MSS_CUST_COUNT_09');
            $table->integer('MSS_CUST_COUNT_10');
            $table->integer('MSS_CUST_COUNT_11');
            $table->integer('MSS_CUST_COUNT_12');
            $table->integer('MSS_CUST_COUNT_13');
            $table->string('MSS_CR_UID');
            $table->string('MSS_CR_DT');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_MONTHWISE_STK_SUM_WEB_HAFL');
    }
};
