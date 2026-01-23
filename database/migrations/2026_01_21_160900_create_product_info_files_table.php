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
        Schema::create('product_info_files', function (Blueprint $table) {
            $table->id();
            $table->string('item_code');
            $table->string('type');
            $table->string('path');
            $table->string('file_name');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();

            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_info_files');
    }
};
