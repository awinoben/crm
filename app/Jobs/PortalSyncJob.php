<?php

namespace App\Jobs;

use App\Http\Controllers\SystemController;
use App\Models\LeadType;
use App\Models\Portal;
use Exception;
use Goutte\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use World\Countries\Model\Country;

class PortalSyncJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // get guzzle client
        $client = new Client();
        $country = Country::query()->firstWhere('slug', 'kenya');
        $lead_type = LeadType::query()->firstWhere('slug', 'individual');

        // pull all the portals defined
        Portal::query()
            ->with([
                'industry.company'
            ])
            ->latest('updated_at')
            ->chunk(100, function ($portals) use ($client, $country, $lead_type) {
                foreach ($portals as $portal) {
                    try {
                        // set the count
                        $count = 0;
                        // pull all urls from the portal
                        foreach ($portal->urls as $url) {
                            // Go to the url website
                            $crawler = $client->request('GET', $url);

                            // process the extraction here
                            $crawler->filter('*')->each(function ($node) use ($portal, $count, $url, $country, $lead_type) {
                                // generate an empty array.
                                $match = $newEmails = array();

                                // String that recognize a e-mail
                                $rules = '/[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}/';

                                // check test pattern in given string
                                preg_match_all($rules, $node->text(), $match);

                                // check if its an array
                                if (count($match[0])) {
                                    foreach ($match[0] as $email) {
                                        $newEmails[] = $email;
                                    }

                                    // check if email array is empty
                                    if (count($newEmails)) {
                                        // define array for companies here
                                        if (count($portal->industry->company)) {
                                            // dispatch the job of storing the leads get.
                                            dispatch(new LeadGenerationJob(
                                                $portal->industry->company,
                                                $newEmails,
                                                $portal->funnels[$count],
                                                $country,
                                                $lead_type,
                                            ))->onQueue('lead_gen')->delay(2);
                                        }
                                    }
                                }
                            });

                            // increment the count to get the specific funnel index matching the url
                            $count++;
                        }
                    } catch (Exception $exception) {
                        Log::error($exception->getMessage());
                        continue;
                    }
                }
            });
    }
}
