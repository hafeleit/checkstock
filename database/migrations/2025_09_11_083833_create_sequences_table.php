<?php

use App\Models\Sequence;
use Carbon\Carbon;
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
        Schema::create('sequences', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('year');
            $table->integer('value')->default(0);
            $table->timestamps();
        });

        Sequence::updateOrCreate([
            'key' => 'logi_track_id',
            'year' => Carbon::now()->year
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sequences');
    }
};
