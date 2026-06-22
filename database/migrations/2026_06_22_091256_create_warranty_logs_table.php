<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('warranty_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('warranty_id')->nullable();
            $table->string('action_type');
            $table->unsignedBigInteger('performed_by');
            $table->jsonb('old_values')->nullable();
            $table->jsonb('new_values')->nullable();
            $table->string('file_name')->nullable();
            $table->unsignedInteger('record_count')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->foreign('warranty_id')->references('id')->on('warranties')->onDelete('set null');
            $table->foreign('performed_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warranty_logs');
    }
};
