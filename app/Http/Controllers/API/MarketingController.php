<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarketingRequest;
use App\Models\Marketing;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MarketingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Marketing::query()
                ->with([
                    'tool',
                    'company'
                ])
                ->where('company_id', request()->user()->company_id)
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MarketingRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(MarketingRequest $request)
    {
        foreach ($request->tool_ids as $tool_id) {
            Marketing::query()->create([
                'campaign_id' => $request->campaign_id,
                'tool_id' => $tool_id,
                'frequency' => $request->frequency,
                'subject' => $request->subject,
                'description' => $request->description,
                'scheduled_at' => date('Y-m-d H:i', strtotime($request->scheduled_at))
            ]);
        }

        return $this->successResponse(['You have successfully scheduled marketing...'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Marketing $marketing
     * @return JsonResponse|Response|object
     */
    public function show(Marketing $marketing)
    {
        return $this->successResponse(
            $marketing->load('tool', 'company')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MarketingRequest $request
     * @param Marketing $marketing
     * @return JsonResponse
     */
    public function update(MarketingRequest $request, Marketing $marketing)
    {
        $marketing->fill($request->validated());

        if ($marketing->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $marketing->save();

        return $this->successResponse($marketing);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Marketing $marketing
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Marketing $marketing)
    {
        $marketing->delete();
        return $this->successResponse($marketing);
    }
}
