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
        Schema::create('page_manual_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('page_identifier');
            $table->longText('question');
            $table->longText('answer');
            $table->string('pdf_file_path')->nullable();
            $table->integer('sequence')->default(1);
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
        Schema::dropIfExists('page_manual_faqs');
    }
};
