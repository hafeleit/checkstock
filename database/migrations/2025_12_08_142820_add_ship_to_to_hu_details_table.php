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
            $table->string('ship_to')->after('shipment_number')->nullable();
            $table->string('ship_to_party_text')->after('ship_to')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hu_details', function (Blueprint $table) {
            $table->dropColumn(['ship_to_party_text', 'ship_to']);
        });
    }
};
