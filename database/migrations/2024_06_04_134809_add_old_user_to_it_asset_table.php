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
            $table->string('old_user')->nullable();
            $table->string('old_name')->nullable();
            $table->string('old_department')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('i_t_assets', function (Blueprint $table) {
            $table->dropColumn('old_user');
            $table->dropColumn('old_name');
            $table->dropColumn('old_department');
        });
    }
};
