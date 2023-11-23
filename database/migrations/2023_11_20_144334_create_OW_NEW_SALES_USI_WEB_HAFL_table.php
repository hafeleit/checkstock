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
        Schema::create('OW_NEW_SALES_USI_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('NSU_COMP_CODE');
            $table->string('NSU_ITEM_CODE');
            $table->string('NSU_ITEM_NAME');
            $table->string('NSU_SHORT_NAME');
            $table->string('NSU_GRADE_CODE_1');
            $table->string('NSU_GRADE_CODE_2');
            $table->string('NSU_CUST_ITEM_CODE');
            $table->string('NSU_ITEM_UOM_CODE');
            $table->string('NSU_NEW_ITEM_CODE');
            $table->string('NSU_SUPP_REPL_TIME');
            $table->string('NSU_PROM_TEXT');
            $table->integer('NSU_CUST_PRICE');
            $table->integer('NSU_SPL_PRICE');
            $table->integer('NSU_BASE_PRICE');
            $table->integer('NSU_VAT_PERC');
            $table->string('NSU_TEN_PERC_DISC');
            $table->string('NSU_TWEN_PERC_DISC');
            $table->string('NSU_THIR_PERC_DISC');
            $table->string('NSU_PURCHASER');
            $table->string('NSU_PROD_MGR');
            $table->string('NSU_PACK_UOM_CODE');
            $table->string('NSU_CONV_BASE_UOM');
            $table->string('NSU_PACK_WEIGHT');
            $table->string('NSU_PACK_VOLUME');
            $table->string('NSU_SALE_MOQ');
            $table->string('NSU_PURC_MOQ');
            $table->string('NSU_PROJ_ITEM_CODE');
            $table->string('NSU_PAR_ITEM_YN');
            $table->string('NSU_CHD_ITEM_YN');
            $table->string('NSU_PP_ITEM_YN');
            $table->string('NSU_BAR_ITEM_YN');
            $table->string('NSU_SUPP_ITEM_CODE');
            $table->string('NSU_ABC_XYZ_ITEM');
            $table->integer('NSU_LSP_VAL');
            $table->string('NSU_LSP_DT');
            $table->integer('NSU_LAST_DISC_PERC');
            $table->integer('NSU_GC_PERC');
            $table->integer('NSU_PICK_QTY');
            $table->integer('NSU_PICK_QTY_LS');
            $table->integer('NSU_FREE_STK_QTY');
            $table->integer('NSU_FREE_STK_QTY_LS');
            $table->integer('NSU_FREE_STK_OTH');
            $table->integer('NSU_FREE_STK_OTH_LS');
            $table->string('NSU_EXCL_REMARK');
            $table->integer('NSU_EXPD_ALL_YN');
            $table->integer('NSU_MTH_STK_FS_YN');
            $table->integer('NSU_TOT_QTY');
            $table->integer('NSU_TOT_QTY_LS');
            $table->integer('NSU_AVG_MTH_QTY');
            $table->integer('NSU_AVG_MTH_QTY_LS');
            $table->integer('NSU_AVG_MTH_CUST');
            $table->string('NSU_ITEM_STATUS');
            $table->string('NSU_TIS_STATUS');
            $table->string('NSU_ITEM_INV_CODE');
            $table->string('NSU_ITEM_LOCK_CODE');
            $table->string('NSU_ITEM_BRAND');
            $table->string('NSU_CR_UID');
            $table->string('NSU_CR_DT');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_NEW_SALES_USI_WEB_HAFL');
    }
};
