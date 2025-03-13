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
        Schema::table('ZHWWBCQUERYDIR', function (Blueprint $table) {
            $table->string('follow_up_material')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ZHWWBCQUERYDIR', function (Blueprint $table) {
            $table->dropcolumn('follow_up_material');
        });
    }
};
