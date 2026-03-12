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
            $table->unsignedBigInteger('file_import_log_id')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_qr_codes', function (Blueprint $table) {
            $table->dropColumn('file_import_log_id');
        });
    }
};
