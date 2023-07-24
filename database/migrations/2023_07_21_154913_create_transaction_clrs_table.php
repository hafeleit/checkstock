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
        Schema::create('transaction_clr', function (Blueprint $table) {
            $table->id();
            $table->string('SOURCE')->nullable();
            $table->string('INV_NO')->nullable();
            $table->datetime('INV_DATE')->nullable();
            $table->string('ITEM_CODE')->nullable();
            $table->string('UOM')->nullable();
            $table->string('QTY')->nullable();
            $table->string('TO_IN_VAT')->nullable();
            $table->string('TO_EX_VAT')->nullable();
            $table->string('BY_CUST')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_clr');
    }
};
