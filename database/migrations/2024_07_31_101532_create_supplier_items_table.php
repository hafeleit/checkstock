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
        Schema::create('supplier_items', function (Blueprint $table) {
            $table->id();
            $table->string('sai_sa_supp_code');
            $table->string('sai_item_code');
            $table->string('sai_si_item_code');
            $table->string('sai_grade_code_1');
            $table->string('sai_pack_no');
            $table->string('sai_mo_qty');
            $table->string('sai_lead_time');
            $table->string('sai_repl_time');
            $table->tinyInteger('status')->default(0);
            $table->string('item_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supplier_items');
    }
};
