<?php

namespace App\Jobs;

use App\Models\Marketing;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MarketingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var string
     */
    private $frequency;

    /**
     * Create a new job instance.
     *
     * @param string $frequency
     */
    public function __construct(string $frequency)
    {
        $this->frequency = $frequency;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Fetch all the marketing depending on frequency given
        Marketing::query()
            ->with([
                'tool',
                'company',
                'campaign.lead'
            ])
            ->latest()
            ->where('frequency', $this->frequency)
            ->whereIn('is_sent', $this->frequency === 'once' ? [false] : [true, false])
            ->chunk(100000, function ($marketings) {
                foreach ($marketings as $marketing) {
                    // check which type of marketing is done.
                    if ($marketing->tool->slug === 'sms') {
                        dispatch(new SmsMarketingJob($marketing))->onQueue('marketing')->delay(2);
                    } elseif ($marketing->tool->slug === 'email') {
                        dispatch(new EmailMarketingJob($marketing))->onQueue('marketing')->delay(2);
                    } elseif ($marketing->tool->slug === 'facebook') {
                        // dispatch here
                    } elseif ($marketing->tool->slug === 'twitter') {
                        // dispatch here
                    } elseif ($marketing->tool->slug === 'youtube') {
                        // dispatch here
                    } elseif ($marketing->tool->slug === 'instagram') {
                        // dispatch here
                    }
                }
            });
    }
}
