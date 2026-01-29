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
        Schema::table('product_infos', function (Blueprint $table) {
            $table->dropForeign(['file_import_log_id']);
            $table->dropForeign(['updated_by']);

            $table->unsignedBigInteger('file_import_log_id')->nullable()->change();
            $table->unsignedBigInteger('updated_by')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_infos', function (Blueprint $table) {
            $table->unsignedBigInteger('file_import_log_id')->nullable(false)->change();
            $table->unsignedBigInteger('updated_by')->nullable(false)->change();

            $table->foreign('file_import_log_id')->references('id')->on('file_import_logs')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
