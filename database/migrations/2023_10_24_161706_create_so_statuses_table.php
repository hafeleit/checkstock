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
        Schema::create('so_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('SOH_TXN_CODE'); //SO_GEN
            $table->string('SOH_NO'); //'2300156404',
            $table->date('SOH_DT'); //2023-10-24
            $table->string('SOH_LPO_NO'); //09.47 24/10/23
            $table->string('SOH_CUST_CODE'); //101941
            $table->string('SOH_CUST_NAME'); //SOUVANNY HOME CENTER PUBLIC COMPANY
            $table->string('SOH_SM_CODE'); //499.98.302
            $table->string('SM_NAME'); //ARIYAWAN  PAVEEPICHAI
            $table->string('SOI_ITEM_CODE'); //4
            $table->string('SOI_ITEM_DESC'); //00483973
            $table->string('SOI_QTY'); //45195
            $table->string('INV_QTY'); //45195
            $table->string('WAVE_ID'); //Pigeonhole Confirmed
            $table->string('WWH_DT'); //DO_EXP-2300000845
            $table->string('WAVE_STS'); //26/09/2023
            $table->string('DO_NO'); //IN_EXP-2300000836
            $table->string('DO_DT'); //27/09/2023
            $table->string('INV_NO'); //Ready to Ship
            $table->string('INV_DT'); //26/09/2023
            $table->string('POD_STATUS'); //26/09/2023
            $table->string('POD_DT');
            $table->date('CREATED_DT');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('so_statuses');
    }
};
