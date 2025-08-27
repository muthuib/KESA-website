<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PendingRegistration;
use Carbon\Carbon;

class CleanPendingRegistrations extends Command
{
    protected $signature = 'registrations:clean-pending';
    protected $description = 'Delete pending registrations older than 1 minute';

    public function handle()
    {
        $cutoff = Carbon::now()->subMinute();

        $deleted = PendingRegistration::where('created_at', '<', $cutoff)->delete();

        $this->info("Deleted {$deleted} pending registrations older than 1 minute.");
    }
}
