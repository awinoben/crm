<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RunningPromotionRequest;
use App\Models\RunningPromotion;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RunningPromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            RunningPromotion::query()
                ->with(['promotion'])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RunningPromotionRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(RunningPromotionRequest $request)
    {
        return $this->successResponse(
            RunningPromotion::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param RunningPromotion $runningPromotion
     * @return JsonResponse|Response|object
     */
    public function show(RunningPromotion $runningPromotion)
    {
        return $this->successResponse(
            $runningPromotion->load('promotion')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RunningPromotionRequest $request
     * @param RunningPromotion $runningPromotion
     * @return JsonResponse
     */
    public function update(RunningPromotionRequest $request, RunningPromotion $runningPromotion)
    {
        $runningPromotion->fill($request->validated());

        if ($runningPromotion->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $runningPromotion->save();

        return $this->successResponse($runningPromotion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param RunningPromotion $runningPromotion
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(RunningPromotion $runningPromotion)
    {
        $runningPromotion->delete();
        return $this->successResponse($runningPromotion);
    }
}
