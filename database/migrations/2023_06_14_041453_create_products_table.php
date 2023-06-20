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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('ITEM_CODE');
            $table->string('ITEM_NAME')->nullable();
            $table->string('ITEM_STATUS')->nullable();
            $table->string('ITEM_INVENTORY_CODE')->nullable();
            $table->string('ITEM_REPL_TIME')->nullable();
            $table->string('ITEM_GRADE_CODE_1')->nullable();
            $table->string('ITEM_UOM_CODE')->nullable();
            $table->string('STOCK_IN_HAND')->nullable();
            $table->string('AVAILABLE_STOCK')->nullable();
            $table->string('PENDING_SO')->nullable();
            $table->string('PROJECT_ITEM')->nullable();
            $table->string('RATE')->nullable();
            $table->string('NEW_ITEM')->nullable();
            $table->integer('STATUS')->default(1);
            $table->integer('DEL')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
