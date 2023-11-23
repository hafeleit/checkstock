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
        Schema::create('OW_ITEMWISE_PO_DTLS_WEB_HAFL', function (Blueprint $table) {
            $table->id();
            $table->string('IPD_COMP_CODE');
            $table->string('IPD_DOC_NO');
            $table->string('IPD_DOC_DT');
            $table->string('IPD_SUPP_CODE');
            $table->string('IPD_WEEK_NO');
            $table->string('IPD_ITEM_CODE');
            $table->string('IPD_GRADE_CODE_1');
            $table->string('IPD_GRADE_CODE_2');
            $table->string('IPD_UOM_CODE');
            $table->string('IPD_QTY_BU');
            $table->string('IPD_QTY');
            $table->string('IPD_QTY_LS');
            $table->string('IPD_MODE_OF_SHIP');
            $table->string('IPD_DEL_LOCN_CODE');
            $table->string('IPD_ETS');
            $table->string('IPD_ETA');
            $table->string('IPD_STATUS');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('OW_ITEMWISE_PO_DTLS_WEB_HAFL');
    }
};
