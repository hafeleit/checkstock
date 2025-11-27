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
            $table->string('email')->after('serial_no')->nullable();
            $table->string('other_channel')->after('order_channel')->nullable();
            $table->string('is_consent_policy')->default('yes');
            $table->string('is_consent_marketing')->default('no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('warranties', function (Blueprint $table) {
            $table->dropColumn(['email', 'other_channel', 'is_consent_policy', 'is_consent_marketing']);
        });
    }
};
