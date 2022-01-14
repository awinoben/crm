<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignRequest;
use App\Models\Campaign;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Campaign::query()
                ->with([
                    'assigned_lead.lead',
                    'company'
                ])
                ->latest()
                ->where('company_id', request()->user()->company_id)
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CampaignRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(CampaignRequest $request)
    {
        $campaign = Campaign::query()->create($request->validated());
        $campaign->update([
            'url' => URL::signedRoute('lead.generation.page', ['slug' => $campaign->slug])
        ]);

        return $this->successResponse($campaign, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Campaign $campaign
     * @return JsonResponse|Response|object
     */
    public function show(Campaign $campaign)
    {
        return $this->successResponse(
            $campaign->load(
                'assigned_lead.lead',
                'company'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CampaignRequest $request
     * @param Campaign $campaign
     * @return JsonResponse
     */
    public function update(CampaignRequest $request, Campaign $campaign)
    {
        $campaign->fill($request->validated());
        if ($campaign->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $campaign->save();

        return $this->successResponse($campaign);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Campaign $campaign
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return $this->successResponse($campaign);
    }
}
