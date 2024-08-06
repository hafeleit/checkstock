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
        Schema::table('warranties', function (Blueprint $table) {
            $table->string('file_name2')->nullable();
            $table->string('file_name3')->nullable();
            $table->string('file_name4')->nullable();
            $table->string('file_name5')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranties', function (Blueprint $table) {
            $table->dropColumn('file_name2');
            $table->dropColumn('file_name3');
            $table->dropColumn('file_name4');
            $table->dropColumn('file_name5');
        });
    }
};
