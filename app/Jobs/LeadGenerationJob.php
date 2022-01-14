<?php

namespace App\Jobs;

use App\Services\LeadGenerationService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class LeadGenerationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var array
     */
    private $companies;
    /**
     * @var array
     */
    private $emails;
    /**
     * @var string
     */
    private $funnel;
    /**
     * @var object
     */
    private $country;
    /**
     * @var object
     */
    private $type;

    /**
     * Create a new job instance.
     * @param $companies
     * @param $emails
     * @param string $funnel
     * @param $country
     * @param $type
     */
    public function __construct($companies, $emails, string $funnel, $country, $type)
    {
        $this->companies = $companies;
        $this->emails = $emails;
        $this->funnel = $funnel;
        $this->country = $country;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // start processing the service here
        (new LeadGenerationService)->store(
            $this->companies,
            $this->emails,
            $this->funnel,
            $this->country,
            $this->type
        );
    }
}
