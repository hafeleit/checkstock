<?php

namespace App\Console\Commands;

use App\Models\Address;
use App\Models\HuDetail;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanUpOldImports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:clean-up-old-imports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutOffDate = Carbon::now()->subDays(5)->endOfDay();

        $addressIds = Address::where('created_at', '<', $cutOffDate)->pluck('id');
        $huDetailIds = HuDetail::where('created_at', '<', $cutOffDate)->pluck('id');

        Address::destroy($addressIds);
        HuDetail::destroy($huDetailIds);
    }
}
