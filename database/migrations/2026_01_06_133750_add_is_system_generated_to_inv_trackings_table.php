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
        Schema::table('inv_trackings', function (Blueprint $table) {
            $table->boolean('is_system_generated')->after('remark')->nullable()->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inv_trackings', function (Blueprint $table) {
            $table->dropColumn('is_system_generated');
        });
    }
};
