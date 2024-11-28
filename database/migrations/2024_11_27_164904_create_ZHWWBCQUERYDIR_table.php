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
        Schema::create('ZHWWBCQUERYDIR', function (Blueprint $table) {
          $table->id(); // Primary Key
          $table->string('material', 50)->nullable();
          $table->string('language', 10)->nullable();
          $table->string('kurztext', 255)->nullable();
          $table->string('angelegta', 20)->nullable();
          $table->string('mtyp', 10)->nullable();
          $table->string('ms', 10)->nullable();
          $table->string('bun', 10)->nullable();
          $table->string('plnt', 10)->nullable();
          $table->string('dm', 10)->nullable();
          $table->string('mrp', 20)->nullable();
          $table->string('lage', 20)->nullable();
          $table->string('model_number', 50)->nullable();
          $table->string('model_name', 255)->nullable();
          $table->string('angel_vo', 20)->nullable();
          $table->string('reason_for_requirement', 255)->nullable();
          $table->string('requestor', 50)->nullable();
          $table->string('vertriebss', 50)->nullable();
          $table->string('werksspez', 50)->nullable();
          $table->string('total_stock', 50)->nullable();
          $table->string('unrestricted', 50)->nullable();
          $table->string('unrestricted_bun', 10)->nullable();
          $table->string('aver_qua_art', 50)->nullable();
          $table->string('aver_qua_art_bun', 10)->nullable();
          $table->string('rounding_val', 50)->nullable();
          $table->string('rounding_val_bun', 10)->nullable();
          $table->string('m', 10)->nullable();
          $table->string('m2', 10)->nullable();
          $table->string('e', 10)->nullable();
          $table->string('b', 10)->nullable();
          $table->string('so', 10)->nullable();
          $table->string('pgr', 10)->nullable();
          $table->string('mrpcn', 10)->nullable();
          $table->string('pdt', 10)->nullable();
          $table->string('war', 50)->nullable();
          $table->string('code_number', 50)->nullable();
          $table->string('orig', 10)->nullable();
          $table->string('ror', 10)->nullable();
          $table->string('a', 10)->nullable();
          $table->string('x', 10)->nullable();
          $table->string('erstverkau', 20)->nullable();
          $table->string('product_group_manager', 50)->nullable();
          $table->string('data_manager', 50)->nullable();
          $table->string('safety_stock', 20)->nullable();
          $table->string('safety_stock_bun', 10)->nullable();
          $table->string('aun', 10)->nullable();
          $table->string('numer', 10)->nullable();
          $table->string('denom', 10)->nullable();
          $table->string('length', 10)->nullable();
          $table->string('length_uod', 10)->nullable();
          $table->string('width', 10)->nullable();
          $table->string('width_uod', 10)->nullable();
          $table->string('height', 10)->nullable();
          $table->string('height_uod', 10)->nullable();
          $table->string('gross_weight', 10)->nullable();
          $table->string('wun', 10)->nullable();
          $table->string('volume', 10)->nullable();
          $table->string('vun', 10)->nullable();
          $table->string('ean_upc', 50)->nullable();
          $table->string('sloc', 10)->nullable();
          $table->string('brand', 50)->nullable();
          $table->string('product_hierarchy_local', 50)->nullable();
          $table->string('product_hierarchy_global', 50)->nullable();
          $table->string('product_hierarchy_bun', 10)->nullable();
          $table->string('package_unit', 10)->nullable();
          $table->string('delivery_unit', 10)->nullable();
          $table->string('posi', 10)->nullable();
          $table->string('tradesmanpu', 10)->nullable();
          $table->string('k', 10)->nullable();
          $table->string('we', 10)->nullable();
          $table->string('st', 10)->nullable();
          $table->string('su', 10)->nullable();
          $table->string('mov_avg_price', 20)->nullable();
          $table->string('crcy1', 10)->nullable();
          $table->string('standard_price', 20)->nullable();
          $table->string('crcy2', 10)->nullable();
          $table->string('per', 10)->nullable();
          $table->string('valcl', 10)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHWWBCQUERYDIR');
    }
};
