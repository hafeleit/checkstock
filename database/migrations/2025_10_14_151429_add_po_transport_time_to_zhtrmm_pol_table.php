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
        Schema::table('zhtrmm_pol', function (Blueprint $table) {
            $table->string('po_transport_time',10)->nullable()->after('po_exp_out_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('zhtrmm_pol', function (Blueprint $table) {
            $table->dropColumn('po_transport_time');
        });
    }
};
