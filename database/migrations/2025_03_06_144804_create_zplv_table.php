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
        Schema::create('zplv', function (Blueprint $table) {
            $table->id();
            $table->string('Material', 20)->nullable(); // 404.14.133
            $table->string('Amount', 20)->nullable();   // 12000
            $table->string('Pricing_unit', 10)->nullable(); // 100
            $table->string('Unit_of_measure', 10)->nullable(); // PCE
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zplv');
    }
};
