<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SystemController;
use App\Http\Requests\LeadStageRequest;
use App\Models\LeadStage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LeadStageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            LeadStage::query()
                ->with([
                    'stage',
                    'lead'
                ])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LeadStageRequest $request
     * @return string
     */
    public function store(LeadStageRequest $request)
    {
        return $this->success.Response(
            LeadStage::query()->create([
                $request->validated()
            ]),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param LeadStage $leadStage
     * @return JsonResponse|Response|object
     */
    public function show(LeadStage $leadStage)
    {
        return $this->successResponse(
            $leadStage->load(
                'stage',
                'lead'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LeadStageRequest $request
     * @param LeadStage $leadStage
     * @return JsonResponse
     */
    public function update(LeadStageRequest $request, LeadStage $leadStage)
    {
        $leadStage->fill($request->validated());
        if ($leadStage->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $leadStage->save();

        return $this->successResponse($leadStage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LeadStage $leadStage
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(LeadStage $leadStage)
    {
        $leadStage->delete();
        return $this->successResponse($leadStage);
    }
}
