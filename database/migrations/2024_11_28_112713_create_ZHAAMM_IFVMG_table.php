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
        Schema::create('ZHAAMM_IFVMG', function (Blueprint $table) {
            $table->id();
            $table->string('purch_organization', 10)->nullable(); // 'TH01'
            $table->string('supplier', 20)->nullable();           // '0000801123'
            $table->string('material', 20)->nullable();           // '950.05.183'
            $table->string('vendor_material_number', 255)->nullable(); // '8101NOT EXTRA MAGNET'
            $table->string('ean_upc', 20)->nullable();            // '8858712453414'
            $table->string('country_of_origin', 10)->nullable();  // 'DE'
            $table->string('order_unit', 10)->nullable();         // 'PCE'
            $table->string('minimum_order_qty', 10)->nullable();  // '1.000'
            $table->string('planned_deliv_time', 10)->nullable(); // '0'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHAAMM_IFVMG');
    }
};
