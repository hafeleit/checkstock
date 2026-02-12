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
            $table->string('bu')->nullable()->after('type');
            $table->string('doc_type')->nullable()->after('bu');
            $table->integer('version')->nullable()->after('doc_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_info_files', function (Blueprint $table) {
            $table->dropColumn(['bu', 'doc_type', 'version']);
        });
    }
};
