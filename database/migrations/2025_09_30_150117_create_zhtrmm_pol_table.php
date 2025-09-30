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
        Schema::create('zhtrmm_pol', function (Blueprint $table) {
            $table->id();
            $table->string("purch_doc")->nullable();
            $table->string("po_doc_date")->nullable();
            $table->string("material")->nullable();
            $table->string("order_quantity")->nullable();
            $table->string("scheduled_quantity")->nullable();
            $table->string("order_unit")->nullable();
            $table->string("st_prod_time")->nullable();
            $table->string("planned_delivery_time")->nullable();
            $table->string("status")->nullable();
            $table->string("po_prod_time")->nullable();
            $table->string("po_exp_out_date")->nullable();
            $table->string("cf_exp_out_date")->nullable();
            $table->string("inb_act_arrival_date")->nullable();
            $table->string("confirm_category")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('zhtrmm_pol');
    }
};
