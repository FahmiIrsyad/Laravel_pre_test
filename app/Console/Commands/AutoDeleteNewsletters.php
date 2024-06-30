<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Newsletter;
use Carbon\Carbon;


class AutoDeleteNewsletters extends Command
{
    protected $signature = 'newsletters:autodelete';
    protected $description = 'Auto delete newsletters after 2 minutes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $newsletters = Newsletter::where('created_at', '<', Carbon::now()->subMinutes(2))->get();
        foreach ($newsletters as $newsletter) {
            $newsletter->delete();
        }
        $this->info('Old newsletters deleted successfully.');
    }
}
