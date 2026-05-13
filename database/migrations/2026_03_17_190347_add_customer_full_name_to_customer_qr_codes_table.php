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
        Schema::table('customer_qr_codes', function (Blueprint $table) {
            $table->string('customer_full_name')->nullable()->after('file_import_log_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_qr_codes', function (Blueprint $table) {
            $table->dropColumn('customer_full_name');
        });
    }
};
