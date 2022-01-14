<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Promotion;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Promotion::query()
                ->with([
                    'company',
                    'running_promotion'
                ])
                ->where('company_id', request()->user()->company_id)
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PromotionRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(PromotionRequest $request)
    {
        return $this->successResponse(
            Promotion::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Promotion $promotion
     * @return JsonResponse|Response|object
     */
    public function show(Promotion $promotion)
    {
        return $this->successResponse(
            $promotion->load('company', 'running_promotion')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PromotionRequest $request
     * @param Promotion $promotion
     * @return JsonResponse
     */
    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $promotion->fill($request->validated());

        if ($promotion->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $promotion->save();

        return $this->successResponse($promotion);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Promotion $promotion
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return $this->successResponse($promotion);
    }
}
