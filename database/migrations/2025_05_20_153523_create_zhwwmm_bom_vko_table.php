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
        Schema::create('zhwwmm_bom_vko', function (Blueprint $table) {
            $table->id();
            $table->string('material', 20)->nullable();        // ตัวอย่าง: 002.81.152
            $table->string('proc_type', 5)->nullable();        // ตัวอย่าง: E
            $table->string('base_quantity', 30)->nullable();   // ตัวอย่าง: 1
            $table->string('bun', 10)->nullable();             // ตัวอย่าง: PCE
            $table->string('bom_usg', 10)->nullable();         // ตัวอย่าง: 1
            $table->string('item', 10)->nullable();            // ตัวอย่าง: 0010
            $table->string('component', 20)->nullable();       // ตัวอย่าง: 480.90.103
            $table->string('quantity', 30)->nullable();        // ตัวอย่าง: 1
            $table->string('un', 10)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zhwwmm_bom_vko');
    }
};
