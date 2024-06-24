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
        Schema::create('product_pack_codes', function (Blueprint $table) {
            $table->id();
            $table->string('IP_ITEM_CODE')->nullable();
            $table->string('IP_PACK_UOM_CODE')->nullable();
            $table->string('IP_CONV_FACTOR')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_pack_codes');
    }
};
