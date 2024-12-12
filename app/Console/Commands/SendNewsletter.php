<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Subscription;
use Illuminate\Support\Facades\Mail;
use App\Mail\Newsletter;

class SendNewsletter extends Command
{ /**
    * The name and signature of the console command.
    *
    * @var string
    */
    protected $signature = 'newsletter:send';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the latest newsletter to all subscribers';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $subscribers = Subscription::all();

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new Newsletter());
        }

        $this->info('Newsletter sent successfully!');
    }
 
}
