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
        Schema::create('MB52', function (Blueprint $table) {
          $table->id();
          $table->string('material', 20)->nullable();
          $table->string('plant', 10)->nullable();
          $table->string('storage_location', 10)->nullable();
          $table->string('special_stock', 5)->nullable();
          $table->string('spec_stk_valuation', 5)->nullable();
          $table->string('special_stock_number', 50)->nullable();
          $table->string('df_stor_loc_level', 10)->nullable();
          $table->string('base_unit_of_measure', 10)->nullable();
          $table->string('unrestricted', 20)->nullable();
          $table->string('stock_segment', 20)->nullable();
          $table->string('currency', 5)->nullable();
          $table->string('value_unrestricted', 20)->nullable();
          $table->string('transit_and_transfer', 20)->nullable();
          $table->string('val_in_trans_tfr', 20)->nullable();
          $table->string('in_quality_insp', 10)->nullable();
          $table->string('value_in_qualinsp', 20)->nullable();
          $table->string('restricted_use_stock', 20)->nullable();
          $table->string('value_restricted', 20)->nullable();
          $table->string('blocked', 10)->nullable();
          $table->string('value_blockedstock', 20)->nullable();
          $table->string('returns', 10)->nullable();
          $table->string('value_rets_blocked', 20)->nullable();
          $table->string('material_description', 255)->nullable();
          $table->string('name_1', 255)->nullable();
          $table->string('material_type', 5)->nullable();
          $table->string('material_group', 5)->nullable();
          $table->string('descr_of_storage_loc', 255)->nullable();
          $table->string('valuated_goods_receipt_blocked_stock', 20)->nullable();
          $table->string('val_gr_blocked_st', 20)->nullable();
          $table->string('tied_empties', 10)->nullable();
          $table->string('val_tied_empties', 20)->nullable();
          $table->string('stock_in_transit', 10)->nullable();
          $table->string('value_in_transit', 20)->nullable();
          $table->string('in_transfer_plant', 10)->nullable();
          $table->string('value_in_stock_tfr', 20)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('MB52');
    }
};
