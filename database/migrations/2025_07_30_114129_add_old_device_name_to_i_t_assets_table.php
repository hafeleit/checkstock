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
        Schema::table('i_t_assets', function (Blueprint $table) {
            $table->string('old_device_name')->nullable()->after('computer_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('i_t_assets', function (Blueprint $table) {
            $table->dropColumn('old_device_name');
        });
    }
};
