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
        Schema::create('ZMM_MATZERT', function (Blueprint $table) {
          $table->id();
          $table->string('material', 20)->nullable();                // ตัวอย่าง: '562.59.054'
          $table->string('supplier', 20)->nullable();                // ตัวอย่าง: '909355'
          $table->string('purch_organization', 10)->nullable();      // ตัวอย่าง: 'TH01'
          $table->string('certificate', 50)->nullable();             // ตัวอย่าง: 'CAESARSTO'
          $table->string('norm_and_flag', 10)->nullable();           // ตัวอย่าง: '0041'
          $table->string('testing_institute', 50)->nullable();       // ตัวอย่าง: ''
          $table->string('certificate_key1', 20)->nullable();         // ตัวอย่าง: ''
          $table->string('valid_to', 20)->nullable();                // ตัวอย่าง: '31/12/9999'
          $table->string('lead_time_in_days', 10)->nullable();       // ตัวอย่าง: '0'
          $table->string('date_of_issue', 20)->nullable();           // ตัวอย่าง: ''
          $table->string('coverage', 10)->nullable();                // ตัวอย่าง: 'N'
          $table->string('certificate_key', 20)->nullable(); // ตัวอย่าง: 'HTH8113'
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZMM_MATZERT');
    }
};
