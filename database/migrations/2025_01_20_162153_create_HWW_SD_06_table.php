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
        Schema::create('HWW_SD_06', function (Blueprint $table) {
          $table->id();
          $table->string('SalesDoc', 20);
          $table->string('Createdat', 20);
          $table->string('Z_MM_JJJJ', 10);
          $table->string('C', 5);
          $table->string('Type', 10);
          $table->string('SOrg', 10);
          $table->string('SOff', 10);
          $table->string('Sold_to', 20);
          $table->string('Cty', 5);
          $table->string('Name', 255);
          $table->string('City', 100);
          $table->string('Ship_to', 20);
          $table->string('Name2', 255);
          $table->string('Cty2', 5);
          $table->string('Item', 10);
          $table->string('ICat', 10);
          $table->string('Plant', 10);
          $table->string('SPlt', 10)->nullable();
          $table->string('Material', 20);
          $table->string('OrderQuantity', 20);
          $table->string('SU', 10);
          $table->string('NetValue', 20);
          $table->string('Curr', 10);
          $table->string('Cost', 20);
          $table->string('Curr2', 10);
          $table->string('ZC', 20);
          $table->string('ZE', 20);
          $table->string('ZI', 20);
          $table->string('ZO', 20);
          $table->string('Createdby', 20);
          $table->string('RR', 20);
          $table->string('ProductHierarchy', 50);
          $table->string('ProdHIII', 20);
          $table->string('ProdHIIIName', 255);
          $table->string('Status', 10);
          $table->string('POtyp', 10)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('HWW_SD_06');
    }
};
