<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeadTypeRequest;
use App\Http\Requests\OpportUnityRequest;
use App\Models\OpportUnity;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class OpportUnityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            OpportUnity::query()
                ->with([
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
     * @param OpportUnityRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(OpportUnityRequest $request)
    {
        return $this->successResponse(
            OpportUnity::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param OpportUnity $opportUnity
     * @return JsonResponse|Response|object
     */
    public function show(OpportUnity $opportUnity)
    {
        return $this->successResponse(
            $opportUnity->load('company')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param LeadTypeRequest $request
     * @param OpportUnity $opportUnity
     * @return JsonResponse|Response|object
     */
    public function update(LeadTypeRequest $request, OpportUnity $opportUnity)
    {
        $opportUnity->fill($request->validated());

        if ($opportUnity->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $opportUnity->save();

        return $this->successResponse($opportUnity);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param OpportUnity $opportUnity
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(OpportUnity $opportUnity)
    {
        $opportUnity->delete();
        return $this->successResponse($opportUnity);
    }
}
