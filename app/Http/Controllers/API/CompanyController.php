<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Company::query()
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
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(CompanyRequest $request)
    {
        return $this->successResponse(
            Company::query()
                ->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Company $company
     * @return JsonResponse|Response|object
     */
    public function show(Company $company)
    {
        return $this->successResponse(
            $company->load(
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
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyRequest $request
     * @param Company $company
     * @return JsonResponse
     */
    public function update(CompanyRequest $request, Company $company)
    {
        $company->fill($request->validated());

        if ($company->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $company->save();

        return $this->successResponse($company);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Company $company)
    {
        $company->delete();
        return $this->successResponse($company);
    }
}
