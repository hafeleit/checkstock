<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ChecUserLastLogin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:check-last-login';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'checks for users who have not logged in for 60 days and sets them to inactive.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cutOffDate = Carbon::now()->subDays(60)->endOfDay();

        // handle users with null last_logged_in_at
        User::whereNull('last_logged_in_at')
            ->update(['last_logged_in_at' => User::raw('created_at')]);

        // update users to inactive
        User::where('last_logged_in_at', '<', $cutOffDate)
            ->where('is_active', true)
            ->update(['is_active' => false]);
    }
}
