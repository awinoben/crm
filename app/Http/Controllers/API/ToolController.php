<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ToolRequest;
use App\Models\Tool;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Tool::query()
                ->with(['marketing'])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ToolRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(ToolRequest $request)
    {
        return $this->successResponse(
            Tool::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Tool $tool
     * @return JsonResponse|Response|object
     */
    public function show(Tool $tool)
    {
        return $this->successResponse(
            $tool->load('marketing')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ToolRequest $request
     * @param Tool $tool
     * @return JsonResponse
     */
    public function update(ToolRequest $request, Tool $tool)
    {
        $tool->fill($request->validated());

        if ($tool->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $tool->save();

        return $this->successResponse($tool);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tool $tool
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Tool $tool)
    {
        $tool->delete();
        return $this->successResponse($tool);
    }
}
