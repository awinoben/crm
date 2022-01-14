<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadTypeRequest;
use App\Models\LeadType;
use App\Traits\NodeResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class LeadTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            LeadType::query()
                ->with(['lead'])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param LeadTypeRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(LeadTypeRequest $request)
    {
        return $this->successResponse(
            LeadType::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param LeadType $leadType
     * @return JsonResponse|Response|object
     */
    public function show(LeadType $leadType)
    {
        return $this->successResponse(
            $leadType->load('lead')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LeadTypeRequest $request
     * @param LeadType $leadType
     * @return JsonResponse
     */
    public function update(LeadTypeRequest $request, LeadType $leadType)
    {
        $leadType->fill($request->validated());

        if ($leadType->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $leadType->save();

        return $this->successResponse($leadType);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param LeadType $leadType
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(LeadType $leadType)
    {
        $leadType->delete();
        return $this->successResponse($leadType);
    }
}
