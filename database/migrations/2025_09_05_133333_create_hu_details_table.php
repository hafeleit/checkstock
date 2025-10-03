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
        Schema::create('hu_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('file_import_log_id');
            $table->string('shipment_number')->nullable();
            $table->string('erp_document')->nullable();
            $table->decimal('total_weight')->nullable();
            $table->string('weight_unit')->nullable();
            $table->decimal('total_volume')->nullable();
            $table->decimal('handling_units')->nullable();
            $table->timestamps();

             $table->foreign('file_import_log_id')->references('id')->on('file_import_logs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hu_details');
    }
};
