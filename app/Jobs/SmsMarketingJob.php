<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SmsMarketingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var object
     */
    private $marketing;

    /**
     * Create a new job instance.
     *
     * @param object $marketing
     */
    public function __construct(object $marketing)
    {
        $this->marketing = $marketing;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // first mark it as queued
        $this->marketing->update([
            'queued_at' => now()
        ]);

        // continue in the sending
        $this->marketing->campaign->assigned_lead()
            ->with('lead')
            ->chunk(10000, function ($assigned_leads) {
                foreach ($assigned_leads as $assigned_lead) {
                    // sms job
                }
            });
    }
}
