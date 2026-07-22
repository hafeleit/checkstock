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
        Schema::table('MB52', function (Blueprint $table) {
            $table->index(['material', 'storage_location'], 'idx_mb52_material_storloc');
        });

        Schema::table('ZHAAMM_IFVMG', function (Blueprint $table) {
            $table->index('material', 'idx_zhaamm_ifvmg_material');
        });

        Schema::table('zhaamm_ifvmg_mat', function (Blueprint $table) {
            $table->index('matnr', 'idx_zhaamm_ifvmg_mat_matnr');
        });

        Schema::table('FIS_MPM_OUT', function (Blueprint $table) {
            $table->index('MATNR', 'idx_fis_mpm_out_matnr');
        });

        Schema::table('ZMM_MATZERT', function (Blueprint $table) {
            $table->index('material', 'idx_zmm_matzert_material');
        });

        Schema::table('ZORDPOSKONV_ZPL', function (Blueprint $table) {
            $table->index('Material', 'idx_zordposkonv_zpl_material');
        });

        Schema::table('zplv', function (Blueprint $table) {
            $table->index('Material', 'idx_zplv_material');
        });

        Schema::table('ZORDPOSKONV_ZPE', function (Blueprint $table) {
            $table->index('Material', 'idx_zordposkonv_zpe_material');
        });

        Schema::table('ZHAASD_ORD', function (Blueprint $table) {
            $table->index(['material', 'sd_document'], 'idx_zhaasd_ord_material_sddoc');
        });

        Schema::table('zhtrmm_pol', function (Blueprint $table) {
            $table->index(['material', 'purch_doc', 'position_no'], 'idx_zhtrmm_pol_material_purchdoc_position');
        });

        Schema::table('ZHINSD_VA05', function (Blueprint $table) {
            $table->index(['material', 'sd_document'], 'idx_zhinsd_va05_material_sddoc');
        });

        Schema::table('ZHAASD_INV', function (Blueprint $table) {
            $table->index(['material', 'sales_document'], 'idx_zhaasd_inv_material_salesdoc');
        });

        Schema::table('zhwwmm_bom_vko', function (Blueprint $table) {
            $table->index('material', 'idx_zhwwmm_bom_vko_material');
            $table->index('component', 'idx_zhwwmm_bom_vko_component');
        });

        Schema::table('OW_MONTHWISE_STK_SUM_WEB_HAFL', function (Blueprint $table) {
            $table->index('MSS_ITEM_CODE', 'idx_ow_monthwise_stk_sum_item_code');
        });

        Schema::table('ZHWWMM_OPEN_ORDERS', function (Blueprint $table) {
            $table->index('material', 'idx_zhwwmm_open_orders_material');
            $table->index('purchasing_document', 'idx_zhwwmm_open_orders_purchasing_document');
        });

        Schema::table('HWW_SD_06', function (Blueprint $table) {
            $table->index(['Material', 'SalesDoc'], 'idx_hww_sd_06_material_salesdoc');
        });

        Schema::table('HWW_SD_CUSTLIS', function (Blueprint $table) {
            $table->index('IDMA_ZI', 'idx_hww_sd_custlis_idma_zi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('MB52', function (Blueprint $table) {
            $table->dropIndex('idx_mb52_material_storloc');
        });

        Schema::table('ZHAAMM_IFVMG', function (Blueprint $table) {
            $table->dropIndex('idx_zhaamm_ifvmg_material');
        });

        Schema::table('zhaamm_ifvmg_mat', function (Blueprint $table) {
            $table->dropIndex('idx_zhaamm_ifvmg_mat_matnr');
        });

        Schema::table('FIS_MPM_OUT', function (Blueprint $table) {
            $table->dropIndex('idx_fis_mpm_out_matnr');
        });

        Schema::table('ZMM_MATZERT', function (Blueprint $table) {
            $table->dropIndex('idx_zmm_matzert_material');
        });

        Schema::table('ZORDPOSKONV_ZPL', function (Blueprint $table) {
            $table->dropIndex('idx_zordposkonv_zpl_material');
        });

        Schema::table('zplv', function (Blueprint $table) {
            $table->dropIndex('idx_zplv_material');
        });

        Schema::table('ZORDPOSKONV_ZPE', function (Blueprint $table) {
            $table->dropIndex('idx_zordposkonv_zpe_material');
        });

        Schema::table('ZHAASD_ORD', function (Blueprint $table) {
            $table->dropIndex('idx_zhaasd_ord_material_sddoc');
        });

        Schema::table('zhtrmm_pol', function (Blueprint $table) {
            $table->dropIndex('idx_zhtrmm_pol_material_purchdoc_position');
        });

        Schema::table('ZHINSD_VA05', function (Blueprint $table) {
            $table->dropIndex('idx_zhinsd_va05_material_sddoc');
        });

        Schema::table('ZHAASD_INV', function (Blueprint $table) {
            $table->dropIndex('idx_zhaasd_inv_material_salesdoc');
        });

        Schema::table('zhwwmm_bom_vko', function (Blueprint $table) {
            $table->dropIndex('idx_zhwwmm_bom_vko_material');
            $table->dropIndex('idx_zhwwmm_bom_vko_component');
        });

        Schema::table('OW_MONTHWISE_STK_SUM_WEB_HAFL', function (Blueprint $table) {
            $table->dropIndex('idx_ow_monthwise_stk_sum_item_code');
        });

        Schema::table('ZHWWMM_OPEN_ORDERS', function (Blueprint $table) {
            $table->dropIndex('idx_zhwwmm_open_orders_material');
            $table->dropIndex('idx_zhwwmm_open_orders_purchasing_document');
        });

        Schema::table('HWW_SD_06', function (Blueprint $table) {
            $table->dropIndex('idx_hww_sd_06_material_salesdoc');
        });

        Schema::table('HWW_SD_CUSTLIS', function (Blueprint $table) {
            $table->dropIndex('idx_hww_sd_custlis_idma_zi');
        });
    }
};
