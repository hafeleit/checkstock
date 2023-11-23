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
        Schema::create('OW_ITEMWISE_SO_DTLS_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('ISD_COMP_CODE');
            $table->string('ISD_DOC_NO');
            $table->string('ISD_DOC_DT');
            $table->string('ISD_CUST_CODE');
            $table->string('ISD_CUST_NAME');
            $table->string('ISD_WEEK_NO');
            $table->string('ISD_ITEM_CODE');
            $table->string('ISD_GRADE_CODE_1');
            $table->string('ISD_GRADE_CODE_2');
            $table->string('ISD_UOM_CODE');
            $table->string('ISD_ORD_QTY_BU');
            $table->string('ISD_ORD_QTY');
            $table->string('ISD_ORD_QTY_LS');
            $table->string('ISD_RESV_QTY_BU');
            $table->string('ISD_RESV_QTY');
            $table->string('ISD_RESV_QTY_LS');
            $table->string('ISD_DEL_QTY_BU');
            $table->string('ISD_DEL_QTY');
            $table->string('ISD_DEL_QTY_LS');
            $table->string('ISD_INV_QTY_BU');
            $table->string('ISD_INV_QTY');
            $table->string('ISD_INV_QTY_LS');
            $table->string('ISD_DEL_DT');
            $table->string('ISD_DEL_LOCN_CODE');
            $table->string('ISD_CURR_CODE');
            $table->string('ISD_RATE');
            $table->string('ISD_VALUE');
            $table->string('ISD_ADMIN');
            $table->string('ISD_ADMIN_NAME');
            $table->string('ISD_REP');
            $table->string('ISD_APPR_STATUS');
            $table->string('IPD_STATUS')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_ITEMWISE_SO_DTLS_WEB_HAFL');
    }
};
