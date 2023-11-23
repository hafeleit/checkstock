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
        Schema::create('OW_WEEKWISE_STK_SUM_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('WSS_COMP_CODE');
            $table->string('WSS_ITEM_CODE');
            $table->string('WSS_ITEM_UOM_CODE');
            $table->string('WSS_GRADE_CODE_1');
            $table->string('WSS_GRADE_CODE_2');
            $table->string('WSS_WEEK_NO');
            $table->integer('WSS_INCOMING_QTY');
            $table->integer('WSS_INCOMING_QTY_LS');
            $table->string('WSS_STATUS');
            $table->integer('WSS_RES_QTY');
            $table->integer('WSS_RES_QTY_LS');
            $table->integer('WSS_AVAIL_QTY');
            $table->integer('WSS_AVAIL_QTY_LS');
            $table->integer('WSS_RCV_QTY');
            $table->integer('WSS_RCV_QTY_LS');
            $table->string('WSS_PLUSMINUS');
            $table->integer('WSS_FREE_QTY');
            $table->integer('WSS_FREE_QTY_LS');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_WEEKWISE_STK_SUM_WEB_HAFL');
    }
};
