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
        Schema::create('ZORDPOSKONV_ZPE', function (Blueprint $table) {
          $table->id(); // Primary key
          $table->string('Customer', 30); // เช่น TH0135665
          $table->string('Name1', 150); // เช่น FARMER PHOYARZAR CO., LTD.
          $table->string('Document', 38); // เช่น 67861556
          $table->string('Item', 33); // เช่น 101
          $table->string('Material', 30); // เช่น 931.14.129
          $table->string('OrderQuantity', 30); // เช่น 10
          $table->string('SU', 20)->nullable(); // เช่น ''
          $table->string('CTyp', 30); // เช่น ZPE
          $table->string('Amount', 90); // เช่น 399826.29
          $table->string('Unit', 20)->nullable(); // เช่น ''
          $table->string('per', 30); // เช่น 100
          $table->string('UoM', 30); // เช่น PCE
          $table->string('Conditionvalue', 80); // เช่น 39982.63
          $table->string('Curr', 20)->nullable(); // เช่น ''
          $table->string('Crcy', 30); // เช่น THB
          $table->string('SU2', 30); // เช่น PCE
          $table->string('Createdby', 100); // เช่น HTH1211
          $table->string('PayT', 30); // เช่น 007
          $table->string('PM', 20)->nullable(); // เช่น ''
          $table->string('Purchaseordernumber', 200)->nullable(); // เช่น HTH-IT-001 EXP/
          $table->string('Createdon', 100); // เช่น 26/11/2024
          $table->string('Customer2', 100); // เช่น HTH1211
          $table->string('Customer3', 100); // เช่น HTH3900
          $table->timestamps(); // created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZORDPOSKONV_ZPE');
    }
};
