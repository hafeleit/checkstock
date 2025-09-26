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
        Schema::create('e_tax_forms', function (Blueprint $table) {
            $table->id();
            $table->string('purchase_channel');
            $table->string('other_channel')->nullable();
            $table->string('order_ref');
            $table->string('customer_name');
            $table->string('phone');
            $table->string('tax_id');
            $table->string('branch_id');
            $table->string('email');
            $table->string('address_line1');
            $table->string('address_line2');
            $table->string('province');
            $table->string('zip_code');
            $table->string('shipping_address_same');
            $table->string('shipping_address_line1')->nullable();
            $table->string('shipping_address_line2')->nullable();
            $table->string('shipping_province')->nullable();
            $table->string('shipping_zip_code')->nullable();
            $table->boolean('pdpa_consent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('e_tax_forms');
    }
};
