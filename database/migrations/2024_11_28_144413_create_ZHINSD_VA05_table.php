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
        Schema::create('ZHINSD_VA05', function (Blueprint $table) {
          $table->id();
          $table->string('sd_document', 50)->nullable();
          $table->string('item_sd', 50)->nullable();
          $table->string('description', 255)->nullable();
          $table->string('sales_document_type', 50)->nullable();
          $table->string('document_date', 50)->nullable();
          $table->string('confirmed_quantity', 50)->nullable();
          $table->string('purchase_order_no', 100)->nullable();
          $table->string('delivery_date', 50)->nullable();
          $table->string('created_by', 50)->nullable();
          $table->string('billing_block', 50)->nullable();
          $table->string('sold_to_party', 50)->nullable();
          $table->string('order_quantity', 50)->nullable();
          $table->string('material', 50)->nullable();
          $table->string('base_unit_of_measure', 50)->nullable();
          $table->string('name1', 255)->nullable();
          $table->string('cust_expected_price', 50)->nullable();
          $table->string('net_price', 50)->nullable();
          $table->string('pricing_unit', 50)->nullable();
          $table->string('unit_of_measure', 50)->nullable();
          $table->string('header_net_value', 50)->nullable();
          $table->string('net_value', 50)->nullable();
          $table->string('division', 50)->nullable();
          $table->string('status', 50)->nullable();
          $table->string('sales_office', 50)->nullable();
          $table->string('sales_group', 50)->nullable();
          $table->string('sales_organization', 50)->nullable();
          $table->string('sales_unit', 50)->nullable();
          $table->string('shipping_point_receiving_pt', 50)->nullable();
          $table->string('distribution_channel', 50)->nullable();
          $table->string('goods_issue_date', 50)->nullable();
          $table->string('document_currency', 50)->nullable();
          $table->string('plant', 50)->nullable();
          $table->string('order_quantity_2', 50)->nullable();
          $table->string('probability', 50)->nullable();
          $table->string('sold_to_address', 255)->nullable();
          $table->string('sd_document_categ', 50)->nullable();
          $table->string('pricing_date', 50)->nullable();
          $table->string('created_on', 50)->nullable();
          $table->string('time', 50)->nullable();
          $table->string('reason_for_rejection', 255)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHINSD_VA05');
    }
};
