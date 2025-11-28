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
        Schema::table('hu_details', function (Blueprint $table) {
            $table->decimal('total_weight', 12, 2)->nullable()->change();
            $table->decimal('total_volume', 12, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hu_details', function (Blueprint $table) {
            $table->decimal('total_weight')->nullable()->change();
            $table->decimal('total_volume')->nullable()->change();
        });
    }
};
