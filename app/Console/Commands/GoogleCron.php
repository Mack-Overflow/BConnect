<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RetrieveGoogleReviewService;

class GoogleCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'google:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Google Command executed successfully';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Google Chron executed");
        RetrieveGoogleReviewService::fetchAll();
        $this->info('Google:Cron works');
        // return 0;
    }
}
