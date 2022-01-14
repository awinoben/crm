<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class SwitchController extends Controller
{
    /**
     * Here switch the company here
     * @param string $id
     * @return JsonResponse|object
     */
    public function switchCompany(string $id)
    {
        // get the company here
        $company = request()->user()->load('companies')->companies()->findOrFail($id);

        // update this option in company
        $company->update([
            'last_accessed_at' => now()
        ]);

        // update the id in the user authenticated
        request()->user()->update([
            'company_id' => $company->id
        ]);

        return $this->successResponse([
            'message' => 'Company switched successfully.'
        ]);
    }


    /**
     * Fetch the active company
     * @return JsonResponse|object
     */
    public function fetchActiveCompany()
    {
        return $this->successResponse(
            request()->user()
                ->load('company')
                ->company()
                ->with([
                    'country',
                    'industry.proposal_template',
                    'industry.invoice_template',
                    'industry.need_template',
                    'industry.key_word',
                    'product',
                    'lead.lead_stage.stage',
                    'opportunity',
                    'sale.lead',
                    'promotion.running_promotion',
                    'sale_funnel.lead',
                    'sale_funnel.social_insight',
                    'sale_funnel.tip',
                    'campaign.assigned_lead.lead.lead_stage.stage',
                    'marketing.tool',
                    'social_insight.sale_funnel',
                    'todo'
                ])
                ->where('id', request()->user()->company_id)
                ->first()
        );
    }
}
