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
        Schema::create('ZHWWSD_OB_WO_I', function (Blueprint $table) {
          $table->id(); // Primary key
          $table->string('SalesDoc', 58); // เช่น 67861548
          $table->string('Sold_topt', 50); // เช่น TH0161586
          $table->string('Plnt', 54); // เช่น TH10
          $table->string('Material', 51); // เช่น 570.26.676
          $table->string('Item', 56); // เช่น 100
          $table->string('Cost', 59); // เช่น 16916.76
          $table->string('Curr', 53); // เช่น THB
          $table->string('FollOndoc', 59); // เช่น 829327033
          $table->string('ExternalDeliveryID', 50); // เช่น 3127000040
          $table->string('Createdon', 50); // เช่น 25/11/2024
          $table->timestamps(); // สำหรับ created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHWWSD_OB_WO_I');
    }
};
