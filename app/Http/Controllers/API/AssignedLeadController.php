<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignLeadToCampaignRequest;
use App\Models\AssignedLead;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AssignedLeadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            AssignedLead::query()
                ->with([
                    'lead',
                    'campaign'
                ])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AssignLeadToCampaignRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(AssignLeadToCampaignRequest $request)
    {
        foreach ($request->leads as $lead) {
            AssignedLead::query()->updateOrCreate([
                'campaign_id' => $request->campaign_id,
                'lead_id' => $lead
            ]);
        }

        return $this->successResponse([
            'message' => 'Assigned ' . count($request->leads) . ' members.'
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param AssignedLead $assignedLead
     * @return JsonResponse|Response|object
     */
    public function show(AssignedLead $assignedLead)
    {
        return $this->successResponse(
            $assignedLead->load(
                'lead',
                'campaign'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AssignedLead $assignedLead
     * @return void
     */
    public function update(Request $request, AssignedLead $assignedLead)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AssignedLead $assignedLead
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(AssignedLead $assignedLead)
    {
        $assignedLead->delete();
        return $this->successResponse($assignedLead);
    }
}
