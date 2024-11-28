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
        Schema::create('ZHWWBCQUERYDIR_PUR', function (Blueprint $table) {
            $table->id();
            $table->string('purch_doc', 20)->nullable();                   // ตัวอย่าง: 24625709
            $table->string('item', 10)->nullable();                        // ตัวอย่าง: 10
            $table->string('plnt', 10)->nullable();                        // ตัวอย่าง: 'TH10'
            $table->string('cocd', 10)->nullable();                        // ตัวอย่าง: 'HTH'
            $table->string('c', 5)->nullable();                            // ตัวอย่าง: 'F'
            $table->string('type', 5)->nullable();                         // ตัวอย่าง: 'ZC'
            $table->string('created_on', 20)->nullable();                  // ตัวอย่าง: '15/08/2024'
            $table->string('created_by', 20)->nullable();                  // ตัวอย่าง: 'SEM001'
            $table->string('vendor', 20)->nullable();                      // ตัวอย่าง: 925160
            $table->string('payt', 10)->nullable();                        // ตัวอย่าง: '030'
            $table->string('pgr', 10)->nullable();                         // ตัวอย่าง: 'T47'
            $table->string('pgr_crcy', 10)->nullable();                    // ตัวอย่าง: 'THB'
            $table->string('exch_rate', 20)->nullable();                   // ตัวอย่าง: 1.00000
            $table->string('ship_type', 20)->nullable();                   // ตัวอย่าง: ''
            $table->string('ehk_po_strategy', 20)->nullable();             // ตัวอย่าง: ''
            $table->string('d', 20)->nullable();                           // ตัวอย่าง: ''
            $table->string('material', 20)->nullable();                    // ตัวอย่าง: '730.33.296'
            $table->string('po_quantity', 20)->nullable();                 // ตัวอย่าง: 30
            $table->string('oun', 10)->nullable();                         // ตัวอย่าง: 'PCE'
            $table->string('oun1', 10)->nullable();                        // ตัวอย่าง: 'PCE'
            $table->string('short_text', 255)->nullable();                 // ตัวอย่าง: 'ZIP LOCK PLASTIC BAG SIZE 6 X 8 CM'
            $table->string('vendor_material_number', 50)->nullable();      // ตัวอย่าง: ''
            $table->string('eq_to', 10)->nullable();                       // ตัวอย่าง: 1
            $table->string('denom', 10)->nullable();                       // ตัวอย่าง: 1
            $table->string('dci', 10)->nullable();                         // ตัวอย่าง: ''
            $table->string('net_value', 20)->nullable();                   // ตัวอย่าง: 600
            $table->string('net_value_crcy', 10)->nullable();              // ตัวอย่าง: 'THB'
            $table->string('per', 10)->nullable();                         // ตัวอย่าง: 100
            $table->string('net_price', 20)->nullable();                   // ตัวอย่าง: 2000
            $table->string('net_price_crcy', 10)->nullable();              // ตัวอย่าง: 'THB'
            $table->string('i', 10)->nullable();                           // ตัวอย่าง: 0
            $table->string('l_ship_type', 20)->nullable();                 // ตัวอย่าง: ''
            $table->string('product_specification', 255)->nullable();      // ตัวอย่าง: ''
            $table->string('mtyp', 10)->nullable();                        // ตัวอย่าง: 'ZVER'
            $table->string('vdr_outpdate', 20)->nullable();                // ตัวอย่าง: '16/08/2024'
            $table->string('production_time_in_days', 10)->nullable();     // ตัวอย่าง: 0
            $table->string('transport_time_in_days', 10)->nullable();      // ตัวอย่าง: 30
            $table->string('usages', 255)->nullable();                      // ตัวอย่าง: ''
            $table->string('purchase_order_number', 50)->nullable();       // ตัวอย่าง: 'k item+K service free+charge'
            $table->string('customer', 50)->nullable();                    // ตัวอย่าง: 'TH0201643'
            $table->string('reference_to_other_vendor', 20)->nullable();   // ตัวอย่าง: 925160
            $table->string('a', 5)->nullable();                            // ตัวอย่าง: 'M'
            $table->string('sloc', 10)->nullable();                        // ตัวอย่าง: 'TH1A'
            $table->string('advanced_po', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHWWBCQUERYDIR_PUR');
    }
};
