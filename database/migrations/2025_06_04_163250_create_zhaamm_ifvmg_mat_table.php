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
        Schema::create('zhaamm_ifvmg_mat', function (Blueprint $table) {
          $table->id();
          $table->string('matnr', 20)->nullable();            // ตัวอย่าง: 003.70.551
          $table->string('werks', 10)->nullable();            // ตัวอย่าง: TH10
          $table->string('ekgrp', 10)->nullable();            // ตัวอย่าง: T09
          $table->string('maktx', 50)->nullable();            // ตัวอย่าง: BAND CLAMP BAN700
          $table->string('spras', 5)->nullable();             // ตัวอย่าง: Z3
          $table->string('verpr', 20)->nullable();            // ตัวอย่าง: 40973.16
          $table->string('prodh', 20)->nullable();            // ตัวอย่าง: THA0F00040
          $table->string('meins', 10)->nullable();            // ตัวอย่าง: PCE
          $table->string('scmng', 10)->nullable();            // ตัวอย่าง: 1.000
          $table->string('mtpos', 10)->nullable();            // ตัวอย่าง: NORM
          $table->string('mvgr4', 10)->nullable();            // ตัวอย่าง: Z02
          $table->string('mvgr4_bezei', 50)->nullable();      // ตัวอย่าง: Non-DIY
          $table->string('mmsta', 10)->nullable();            // ตัวอย่าง: ZR
          $table->string('mmsta_mtstb', 50)->nullable();      // ตัวอย่าง: Sell out & Delete
          $table->string('vmsta', 10)->nullable();            // ตัวอย่าง: ZR
          $table->string('vmsta_vmstb', 50)->nullable();      // ตัวอย่าง: Sell out & delete
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zhaamm_ifvmg_mat');
    }
};
