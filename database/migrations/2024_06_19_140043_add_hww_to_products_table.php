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
        Schema::table('products', function (Blueprint $table) {
            $table->string('FREE_STOCK')->nullable();
            $table->string('SUPP_NAME')->nullable();
            $table->string('MOQ')->nullable();
            $table->string('ITEM_REMARK')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('FREE_STOCK');
            $table->dropColumn('SUPP_NAME');
            $table->dropColumn('MOQ');
            $table->dropColumn('ITEM_REMARK');
        });
    }
};
