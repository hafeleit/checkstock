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
        Schema::create('HWW_SD_CUSTLIS', function (Blueprint $table) {
          $table->id();
          $table->string('Customer', 20);
          $table->string('Name1', 255);
          $table->string('Name2', 255);
          $table->string('City', 100);
          $table->string('ZIP_Code', 20);
          $table->string('Rg', 25);
          $table->string('Ctry',25);
          $table->string('Street', 255);
          $table->string('Phone', 150)->nullable();
          $table->string('EMailAddress', 255)->nullable();
          $table->string('Createdby', 150);
          $table->string('Createdat', 50);
          $table->string('UIDnumber', 150)->nullable();
          $table->string('Alloweasylink', 150)->nullable();
          $table->string('PINchange', 150)->nullable();
          $table->string('SOff', 50);
          $table->string('SGr', 50);
          $table->string('MS', 50);
          $table->string('CS1', 50);
          $table->string('P1', 50);
          $table->string('CS2', 50);
          $table->string('P2', 50);
          $table->string('CS3', 50);
          $table->string('P3', 50);
          $table->string('C1', 50);
          $table->string('C2', 50);
          $table->string('C3', 50);
          $table->string('CTy', 50);
          $table->string('IndS', 50)->nullable();
          $table->string('KG2', 50);
          $table->string('KG3', 50);
          $table->string('PG', 50);
          $table->string('RG2', 50);
          $table->string('PTer', 50);
          $table->string('IncoT', 50);
          $table->string('Plant', 50);
          $table->string('IDMA_ZI', 50);
          $table->string('IDMA_ZI_NAME', 255);
          $table->string('ADMA_ZE', 50);
          $table->string('ADMA_ZE_NAME', 255);
          $table->string('EPS_ZC', 50);
          $table->string('EPS_ZC_NAME', 255);
          $table->string('VBL_ZO', 50);
          $table->string('VBL_ZO_NAME', 255);
          $table->string('KUECHENEXP', 150)->nullable();
          $table->string('OM_AD', 150)->nullable();
          $table->string('PRE_BL_SH', 150)->nullable();
          $table->string('PRE_MA_MK', 150)->nullable();
          $table->string('PRE_SCH_TW', 150)->nullable();
          $table->string('PRO_SER_BE', 150)->nullable();
          $table->string('VVK_ID', 150)->nullable();
          $table->string('VVK_AD', 150)->nullable();
          $table->string('VVK_AD_ADOP', 150)->nullable();
          $table->string('Creditlimit', 120);
          $table->string('FI_BLK', 150)->nullable();
          $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('HWW_SD_CUSTLIS');
    }
};
