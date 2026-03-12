<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CleanTempQrCode extends Command
{
    protected $signature = 'app:clean-temp-qr-code';
    protected $description = 'Delete temporary QR code images older than 24 hours';

    public function handle()
    {
        $directory = storage_path('app/public/tmp');

        // Check if directory exists before proceeding
        if (!File::exists($directory)) {
            $this->warn("Directory does not exist: {$directory}");
            return;
        }

        $files = File::files($directory);
        $count = 0;

        // Loop through and delete each file
        foreach ($files as $file) {
            File::delete($file);
            $count++;
        }

        $this->info("Successfully deleted {$count} temporary QR code(s).");
    }
}
