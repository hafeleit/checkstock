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
        Schema::create('ZHTRSD_SALES', function (Blueprint $table) {
          $table->id();
            $table->string('SDDocument', 90);  // เช่น '716152153'
            $table->string('Customer', 100);  // เช่น 'TH0105516'
            $table->string('CustomerName', 255);  // เช่น 'ANDAMAN RESORT CO., LTD.'
            $table->string('Material', 200);  // เช่น '101.69.510'
            $table->string('MaterialDescription', 255);  // เช่น 'Handle zi.bl.ma.antibak.100x24mm right'
            $table->string('BaseUnitofMeasure', 30);  // เช่น 'PCE'
            $table->string('OrderQuantity', 100);  // เช่น '10'
            $table->string('OpenQuantity', 100);  // เช่น '0'
            $table->string('ItemCategory', 53);  // เช่น 'ZWS'
            $table->string('Plant', 55);  // เช่น 'TH10'
            $table->string('CreatedOn', 110);  // เช่น '07/11/2024'
            $table->string('FirstDate', 110);  // เช่น '07/11/2024'
            $table->string('Item_SD', 110);  // เช่น '100'
            $table->string('NetValue', 120);  // เช่น '2298'
            $table->string('UnitPrice', 120);  // เช่น '0'
            $table->string('OpenQuantityPrice', 120);  // เช่น '0'
            $table->string('Margin', 120);  // เช่น '46.62'
            $table->string('ActiveConditionType', 150);  // เช่น ''
            $table->string('Description', 255);  // เช่น 'HANDLEZI.BL.MATT HYG100X23MM R'
            $table->string('Reasonforrejection', 255);  // เช่น ''
            $table->string('DocumentCurrency', 53);  // เช่น 'THB'
            $table->string('Openquantityafterwarehousedelivery', 110);  // เช่น '0'
            $table->string('CreatedBy', 150);  // เช่น 'SEM001'
            $table->string('SalesDocumentType', 53);  // เช่น 'ZOS'
            $table->string('SalesOffice', 54);  // เช่น 'THSU'
            $table->string('Deliveryblock', 55);  // เช่น ''
            $table->string('CreditBlock', 55);  // เช่น ''
            $table->string('GrossMarginStatus', 53);  // เช่น ''
            $table->string('BlockStatus', 53);  // เช่น ''
            $table->string('Deliveryquantity', 110);  // เช่น '10'
            $table->string('ProjectDescription', 255);  // เช่น ''
            $table->string('PurchaseOrderDate', 110);  // เช่น '07/11/2024'
            $table->string('PurchaseOrderNumber', 120);  // เช่น 'Naren2'
            $table->string('Stockkeepingindicator', 53);  // เช่น 'NLW'
            $table->string('Adma', 200);  // เช่น 'AKWARONG PHUPONGPHIPHAT'
            $table->string('Idma', 200);  // เช่น 'SARUDA KONTACHAROENSRI'
            $table->string('MRPController', 110);  // เช่น 'T82'
            $table->string('Unrestricted', 110);  // เช่น '3'
            $table->string('Pricingunit', 55);  // เช่น '100'
            $table->string('Discount', 55);  // เช่น '0'
            $table->string('Goodsissuequantity', 110);  // เช่น '10'
            $table->string('Goodsissuedate', 110);  // เช่น '07/11/2024'
            $table->string('LastDate', 100);  // เช่น '07/11/2024'
            $table->string('SalesChannel2', 120);  // เช่น 'Retail-TT'
            $table->string('SalesChannel1', 120);  // เช่น ''
            $table->string('TermsofPayment', 150);  // เช่น '30 days after invoice date net'
            $table->string('Ownexplanation', 255);  // เช่น ''
            $table->string('Customergroup', 50);  // เช่น 'T04'
            $table->string('SalesGroup', 50);  // เช่น 'T04'
            $table->string('Doc_conditionno', 150);  // เช่น ''
            $table->string('ExchangeRate', 100);  // เช่น ''
            $table->string('Purchasinggroup', 50);  // เช่น 'T04'
            $table->timestamps();  // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ZHTRSD_SALES');
    }
};
