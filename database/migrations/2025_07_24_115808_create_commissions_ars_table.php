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
        Schema::create('commissions_ars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('commissions_id')->nullable(); // FK ไป commissions table
            $table->string('type')->nullable();
            //ar
            $table->string('account')->nullable();
            $table->string('name')->nullable();
            $table->string('document_type')->nullable();
            $table->string('reference')->nullable();
            $table->string('reference_key')->nullable();
            $table->date('document_date')->nullable();
            $table->date('clearing_date')->nullable();
            $table->string('amount_in_local_currency', 15, 2)->nullable();
            $table->string('local_currency')->nullable();
            $table->string('clearing_document')->nullable();
            $table->text('text')->nullable();
            $table->string('posting_key')->nullable();
            $table->string('sales_rep')->nullable();
            $table->unsignedBigInteger('schema_id')->nullable();
            $table->decimal('ar_rate', 10, 4)->nullable();
            $table->decimal('ar_rate_percent', 10, 2)->nullable();
            $table->decimal('commissions', 15, 2)->nullable();
            $table->string('status')->nullable();
            $table->string('adjuster')->nullable();
            $table->text('remark')->nullable();

            //cn
            $table->string('cn_billing_ref')->nullable();
            $table->string('cn_sales_doc')->nullable();
            $table->date('cn_order_date')->nullable();
            $table->string('cn_no')->nullable();
            $table->date('cn_date')->nullable();
            $table->string('cn_sales_name')->nullable();
            $table->string('cn_tax_invoice')->nullable();
            $table->string('cn_sales_doc_name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commissions_ars');
    }
};
