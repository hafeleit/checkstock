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
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->string('bar_code',20);
            $table->string('item_desc_en',100);
            $table->string('suggest_text',50);
            $table->string('made_by',30);
            $table->string('material_text',30);
            $table->string('warning_text',30);
            $table->string('how_to_text',30);
            $table->string('product_name',50);
            $table->string('item_code',20);
            $table->string('grade_code_1',10);
            $table->string('material_color',30);
            $table->string('remark',100);
            $table->string('item_size',50);
            $table->string('item_amout',20);
            $table->string('item_type',20);
            $table->string('factory_name');
            $table->string('factory_address');

            $table->string('format_id',20)->nullable();
            $table->string('supplier_code',20)->nullable();
            $table->string('supplier_item',20)->nullable();
            $table->string('type',50)->nullable();
            $table->string('format',50)->nullable();
            $table->string('model',50)->nullable();
            $table->string('price',50)->nullable();
            $table->string('hafele_addr')->nullable();
            $table->string('manf_date',50)->nullable();
            $table->string('country_code',10)->nullable();
            $table->string('defrosting',5)->nullable();
            $table->string('gross_int',20)->nullable();
            $table->string('nominal_voltage',20)->nullable();
            $table->string('nominal_freq',10)->nullable();
            $table->decimal('defrosting_power',10)->nullable();
            $table->decimal('nominal_electricity',2)->nullable();
            $table->integer('max_power_of_lamp')->nullable();
            $table->integer('electric_power_phase')->nullable();
            $table->integer('nominal_power')->nullable();
            $table->string('star_rating_freezer',20)->nullable();
            $table->integer('energy_cons_per_year')->nullable();
            $table->string('climate_class',10)->nullable();
            $table->string('refrigerant',30)->nullable();
            $table->string('tis_1',30)->nullable();
            $table->string('tis_2',30)->nullable();
            $table->string('series_name',30)->nullable();
            $table->string('qr_code')->nullable();
            $table->string('color',10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
