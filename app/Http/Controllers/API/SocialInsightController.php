<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SocialInsightRequest;
use App\Models\SocialInsight;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SocialInsightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            SocialInsight::query()
                ->with([
                    'sale_funnel',
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
     * @param SocialInsightRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(SocialInsightRequest $request)
    {
        return $this->successResponse(
            SocialInsight::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param SocialInsight $socialInsight
     * @return JsonResponse|Response|object
     */
    public function show(SocialInsight $socialInsight)
    {
        return $this->successResponse(
            $socialInsight->load('sale_funnel', 'company')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SocialInsightRequest $request
     * @param SocialInsight $socialInsight
     * @return JsonResponse
     */
    public function update(SocialInsightRequest $request, SocialInsight $socialInsight)
    {
        $socialInsight->fill($request->validated());

        if ($socialInsight->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $socialInsight->save();

        return $this->successResponse($socialInsight);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SocialInsight $socialInsight
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(SocialInsight $socialInsight)
    {
        $socialInsight->delete();
        return $this->successResponse($socialInsight);
    }
}
