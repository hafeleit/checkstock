<?php

namespace App\Helpers;

class LogiTrackIdHelper
{
    public static function generate($type)
    {
        $prefix = $type == 'deliver' ? 'D' : 'R';
        $logiTrackId = $prefix . '-' . now()->timestamp;

        return $logiTrackId;
    }
}
