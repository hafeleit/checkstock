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
        Schema::create('i_t_assets', function (Blueprint $table) {
            $table->id();
            $table->string('computer_name');
            $table->string('serial_number')->nullable();
            $table->string('type');
            $table->string('color')->nullable();
            $table->string('model');
            $table->string('fixed_asset_no')->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('warranty')->nullable();
            $table->string('status');
            $table->string('location')->nullable();
            $table->string('create_by')->nullable();
            $table->integer('delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('i_t_assets');
    }
};
