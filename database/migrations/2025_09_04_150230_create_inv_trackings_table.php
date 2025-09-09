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
        Schema::create('inv_trackings', function (Blueprint $table) {
            $table->id();
            $table->string('logi_track_id');
            $table->string('erp_document');
            $table->string('invoice_id')->nullable();
            $table->string('driver_or_sent_to');
            $table->string('type');
            $table->string('status');
            $table->timestamp('delivery_date')->nullable();
            $table->timestamp('created_date')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inv_trackings');
    }
};
