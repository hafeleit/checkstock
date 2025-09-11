<?php

namespace App\Helpers;

use App\Models\Sequence;
use Carbon\Carbon;

class LogiTrackIdHelper
{
    public static function generate($type)
    {
        $prefix = ($type == 'deliver') ? 'D' : 'R';
        $year = Carbon::now()->year;

        \DB::transaction(function () use (&$sequence, $year) {
            $sequence = Sequence::firstOrCreate(
                ['key' => 'logi_track_id', 'year' => $year],
                ['value' => 0]
            );

            $sequence->increment('value');
        });

        $running_number = str_pad($sequence->value, 6, '0', STR_PAD_LEFT);
        $short_year = substr($year, -2);

        return $prefix . $short_year . '-' . $running_number;
    }
}
