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
        Schema::create('ZHAASD_INV', function (Blueprint $table) {
          $table->id();
          $table->string('sold_to_party', 20)->nullable();
          $table->string('invoiced_quantity', 20)->nullable();
          $table->string('name', 255)->nullable();
          $table->string('billing_document', 50)->nullable();
          $table->string('billing_type', 20)->nullable();
          $table->string('po_number', 50)->nullable();
          $table->string('billing_date', 20)->nullable();
          $table->string('created_on', 20)->nullable();
          $table->string('item', 20)->nullable();
          $table->string('material', 50)->nullable();
          $table->string('description', 255)->nullable();
          $table->string('sales_unit', 20)->nullable();
          $table->string('net_value', 20)->nullable();
          $table->string('gross_value', 20)->nullable();
          $table->string('posting_status', 20)->nullable();
          $table->string('short_descript', 255)->nullable();
          $table->string('postal_code', 20)->nullable();
          $table->string('city', 255)->nullable();
          $table->string('rebate_group', 20)->nullable();
          $table->string('customer_state', 20)->nullable();
          $table->string('sales_office', 50)->nullable();
          $table->string('sales_rep', 50)->nullable();
          $table->string('name2', 255)->nullable();
          $table->string('product_hierarchy', 50)->nullable();
          $table->string('country_key', 5)->nullable();
          $table->string('name3', 255)->nullable();
          $table->string('document_currency', 5)->nullable();
          $table->string('sddocumentcateg', 20)->nullable();
          $table->string('higher_levelite', 20)->nullable();
          $table->string('sales_document', 50)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHAASD_INV');
    }
};
