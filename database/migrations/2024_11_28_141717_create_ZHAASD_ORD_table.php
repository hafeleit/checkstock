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
        Schema::create('ZHAASD_ORD', function (Blueprint $table) {
          $table->id();
          $table->string('sd_document', 50)->nullable();
          $table->string('item', 50)->nullable();
          $table->string('doc_type', 20)->nullable();
          $table->string('material', 50)->nullable();
          $table->string('customer_material', 50)->nullable();
          $table->string('req_del_qty', 20)->nullable();
          $table->string('delivered_qty', 20)->nullable();
          $table->string('sales_unit', 20)->nullable();
          $table->string('description', 255)->nullable();
          $table->string('req_del_date', 20)->nullable();
          $table->string('conf_del_date', 20)->nullable();
          $table->string('comment', 255)->nullable();
          $table->string('availability', 20)->nullable();
          $table->string('days_delayed', 20)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHAASD_ORD');
    }
};
