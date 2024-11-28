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
        Schema::create('ZHWWMM_OPEN_ORDERS', function (Blueprint $table) {
          $table->id();
          $table->string('purch_organization', 20)->nullable();
          $table->string('purchasing_document', 20)->nullable();
          $table->string('item', 10)->nullable();
          $table->string('created_on_purchasing_doc', 20)->nullable();
          $table->string('purchasing_doc_type', 5)->nullable();
          $table->string('purchasing_group', 5)->nullable();
          $table->string('supplier', 20)->nullable();
          $table->string('deletion_indicator', 5)->nullable();
          $table->string('material', 20)->nullable();
          $table->string('short_text', 255)->nullable();
          $table->string('plant', 10)->nullable();
          $table->string('quantity_po', 10)->nullable();
          $table->string('po_order_unit', 10)->nullable();
          $table->string('net_order_value', 20)->nullable();
          $table->string('currency', 5)->nullable();
          $table->string('vendor_output_date', 20)->nullable();
          $table->string('confirmed_issue_date', 20)->nullable();
          $table->string('confirmed_delivery_date', 20)->nullable();
          $table->string('scheduled_quantity', 10)->nullable();
          $table->string('quantity_oc', 10)->nullable();
          $table->string('oc_order_unit', 10)->nullable();
          $table->string('open_inv_quantity_po_item', 10)->nullable();
          $table->string('delivered_quantity', 10)->nullable();
          $table->string('sold_to_party', 20)->nullable();
          $table->string('purchase_order_no', 20)->nullable();
          $table->string('ehk_po_strategy', 20)->nullable();
          $table->string('usages', 255)->nullable();
          $table->string('delivery_completed', 5)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHWWMM_OPEN_ORDERS');
    }
};
