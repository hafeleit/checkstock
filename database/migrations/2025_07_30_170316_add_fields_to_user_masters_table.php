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
        Schema::table('user_masters', function (Blueprint $table) {
          $table->string('employee_code')->nullable()->after('id');
          $table->string('division')->nullable()->after('employee_code');
          $table->string('manager')->nullable()->after('division');
          $table->string('status')->nullable()->after('manager');
          $table->date('effecttive_date')->nullable()->after('status');
          $table->string('job_title')->nullable()->after('effecttive_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_masters', function (Blueprint $table) {
          $table->dropColumn([
              'employee_code',
              'division',
              'manager',
              'status',
              'effecttive_date',
              'job_title',
          ]);
        });
    }
};
