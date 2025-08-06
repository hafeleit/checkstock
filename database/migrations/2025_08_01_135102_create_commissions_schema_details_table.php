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
        Schema::create('commissions_schema_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commissions_schemas_id')->nullable(); // FK ไป commissions table
            $table->string('division_name');
            $table->string('ar_start',10)->nullable();
            $table->string('ar_end',10)->nullable();
            $table->decimal('rate_percent', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions_schema_details');
    }
};
