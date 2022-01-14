<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use App\Models\NeedTemplate;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class NeedTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            NeedTemplate::query()
                ->with([
                    'industry'
                ])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TemplateRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(TemplateRequest $request)
    {
        return $this->successResponse(
            NeedTemplate::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param NeedTemplate $needTemplate
     * @return JsonResponse|Response|object
     */
    public function show(NeedTemplate $needTemplate)
    {
        return $this->successResponse(
            $needTemplate->load(
                'industry'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TemplateRequest $request
     * @param NeedTemplate $needTemplate
     * @return JsonResponse
     */
    public function update(TemplateRequest $request, NeedTemplate $needTemplate)
    {
        $needTemplate->fill($request->validated());
        if ($needTemplate->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $needTemplate->save();

        return $this->successResponse($needTemplate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NeedTemplate $needTemplate
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(NeedTemplate $needTemplate)
    {
        $needTemplate->delete();
        return $this->successResponse($needTemplate);
    }
}
