<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Models\Lead;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Lead::query()
                ->with([
                    'company',
                    'assigned_lead.campaign',
                    'country',
                    'lead_type',
                    'sale',
                    'sale_funnel',
                    'lead_stage'
                ])
                ->where('company_id', request()->user()->company_id)
                ->where('is_contact', true)
                ->oldest('score')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LeadRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(LeadRequest $request)
    {
        return $this->successResponse(
            Lead::query()->create($request->validated())->update(['is_contact' => true]),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Lead $lead
     * @return JsonResponse|Response|object
     */
    public function show(Lead $lead)
    {
        return $this->successResponse(
            $lead->load(
                'company',
                'assigned_lead.campaign',
                'country',
                'lead_type',
                'sale',
                'sale_funnel',
                'lead_stage'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateLeadRequest $request
     * @param Lead $lead
     * @return JsonResponse
     */
    public function update(UpdateLeadRequest $request, Lead $lead)
    {
        $lead->fill($request->validated())->update(['is_customer' => true]);

        if ($lead->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $lead->save();

        return $this->successResponse($lead);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Lead $lead
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();
        return $this->successResponse($lead);
    }
}
