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
        Schema::create('product_items', function (Blueprint $table) {
            $table->id();
            $table->string('bar_code');
            $table->string('item_desc_en');
            $table->string('suggest_text');
            $table->string('made_by');
            $table->string('material_text');
            $table->string('warning_text');
            $table->string('how_to_text');
            $table->string('product_name');
            $table->string('item_code');
            $table->string('grade_code_1');
            $table->string('material_color');
            $table->string('remark');
            $table->string('item_size');
            $table->string('item_amout');
            $table->string('item_type');
            $table->string('factory_name');
            $table->string('factory_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_items');
    }
};
