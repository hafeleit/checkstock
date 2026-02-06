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
        Schema::table('product_info_files', function (Blueprint $table) {
            $table->string('bu_detail')->after('item_code')->nullable();
            $table->boolean('is_active')->default(true)->after('file_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_info_files', function (Blueprint $table) {
            $table->dropColumn(['is_active', 'bu_detail']);
        });
    }
};
