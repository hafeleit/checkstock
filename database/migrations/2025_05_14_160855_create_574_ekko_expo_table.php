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
        Schema::create('574_ekko_expo', function (Blueprint $table) {
          $table->id();
          $table->string('purch_doc', 50)->nullable();                // ตัวอย่าง: 24901843
          $table->string('created_on', 50)->nullable();               // ตัวอย่าง: 4/29/2025
          $table->string('vendor', 50)->nullable();                   // ตัวอย่าง: 923456
          $table->string('material', 50)->nullable();                 // ตัวอย่าง: เว้นว่าง
          $table->string('po_quantity', 50)->nullable();              // ตัวอย่าง: 1
          $table->string('oun', 10)->nullable();                      // ตัวอย่าง: PCE
          $table->string('denom', 50)->nullable();                    // ตัวอย่าง: 0
          $table->string('ship_type', 50)->nullable();                // ตัวอย่าง: 0005
          $table->string('vdr_outp_date', 50)->nullable();            // ตัวอย่าง: 5/29/2025
          $table->string('production_time_in_days', 50)->nullable();  // ตัวอย่าง: 30
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('574_ekko_expo');
    }
};
