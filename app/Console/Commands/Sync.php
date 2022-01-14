<?php

namespace App\Console\Commands;

use App\Jobs\MarketingJob;
use Illuminate\Console\Command;

class Sync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:crm';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command always syncs all latest data to ensure we have accurate projections';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // schedule here
        dispatch(new MarketingJob('once'))->onQueue('default')->delay(2);
    }
}
