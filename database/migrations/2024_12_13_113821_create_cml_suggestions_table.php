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
        Schema::create('cml_suggestions', function (Blueprint $table) {
          $table->id();
          $table->string('suggestion_code', 10);
          $table->string('suggestion_description', 200); // ควรตรวจสอบการรั่วซึมข้อต่อและสายแก๊สก่อนใช้งาน มีความยาว 51 ตัวอักษร (UTF-8)
          $table->timestamps(); // สร้าง created_at และ updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cml_suggestions');
    }
};
