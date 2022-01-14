<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StageRequest;
use App\Models\Stage;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class StageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Stage::query()
                ->with([
                    'lead_stage.lead'
                ])
                ->oldest('level')
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StageRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(StageRequest $request)
    {
        return $this->successResponse(
            Stage::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Stage $stage
     * @return JsonResponse|Response|object
     */
    public function show(Stage $stage)
    {
        return $this->successResponse(
            $stage->load(
                'lead_stage.lead'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StageRequest $request
     * @param Stage $stage
     * @return JsonResponse|Response|object
     */
    public function update(StageRequest $request, Stage $stage)
    {
        $stage->fill($request->validated());

        if ($stage->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $stage->save();

        return $this->successResponse($stage);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Stage $stage
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Stage $stage)
    {
        $stage->delete();
        return $this->successResponse($stage);
    }
}
