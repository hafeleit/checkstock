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
        Schema::create('OW_ITEM_UOM_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('IUW_ITEM_CODE');
            $table->string('IUW_UOM_CODE');
            $table->integer('IUW_CONV_FACTOR');
            $table->integer('IUW_MAX_LOOSE');
            $table->integer('IUW_MAX_LOOSE_1');
            $table->string('IUW_PRICE_LIST');
            $table->string('IUW_PRICE');
            $table->string('IUW_DISC_PRICE');
            $table->string('IUW_NET_PRICE');
            $table->string('IUW_GRADE_CODE_1');
            $table->string('IUW_GRADE_CODE_2');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_ITEM_UOM_WEB_HAFL');
    }
};
