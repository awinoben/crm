<?php


namespace App\Services;


use App\Models\Lead;
use App\Models\SaleFunnel;

class LeadGenerationService
{
    /**
     * @var string
     */
    private $filter;

    /**
     * initiate a service here
     * @param string $filter
     */
    public function __construct(string $filter = "*")
    {
        $this->filter = $filter;
    }

    /**
     * process and store all got leads here depending on the country
     * @param $companies
     * @param $emails
     * @param string $funnel
     * @param $country
     * @param $type
     */
    public function store($companies, $emails, string $funnel, $country, $type)
    {
        // model query
        $query = new Lead();
        $query_funnel = new SaleFunnel();

        // loop through all the emails
        foreach ($emails as $email) {
            // check if the lead exists here
            $lead = $query->newQuery()
                ->where('email', $email)
                ->first();

            // continue
            if (!$lead) {
                if (count($companies))
                    // loop all companies
                    foreach ($companies as $company) {
                        // check if funnel exists
                        $funnel_data = $query_funnel->newQuery()->firstWhere('name', $funnel);
                        if (!$funnel_data)
                            $query_funnel->newQuery()->create([
                                'company_id' => $company->id,
                                'name' => $funnel
                            ]);

                        $query->newQuery()->updateOrCreate([
                            'country_id' => $country->id,
                            'sale_funnel_id' => $funnel_data->id,
                            'company_id' => $company->id,
                            'lead_type_id' => $type->id,
                            'name' => strstr($email, '@', true),
                            'email' => $email
                        ]);
                    }
            }
        }

    }
}
