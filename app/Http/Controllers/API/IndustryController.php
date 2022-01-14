<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndustryRequest;
use App\Models\Industry;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class IndustryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Industry::query()
                ->with([
                    'company',
                    'proposal_template',
                    'need_template',
                    'invoice_template',
                ])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param IndustryRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(IndustryRequest $request)
    {
        return $this->successResponse(
            Industry::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Industry $industry
     * @return JsonResponse|Response|object
     */
    public function show(Industry $industry)
    {
        return $this->successResponse(
            $industry->load(
                'company',
                'need_template',
                'invoice_template',
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param IndustryRequest $request
     * @param Industry $industry
     * @return JsonResponse
     */
    public function update(IndustryRequest $request, Industry $industry)
    {
        $industry->fill($request->validated());
        if ($industry->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $industry->save();

        return $this->successResponse($industry);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Industry $industry
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Industry $industry)
    {
        $industry->delete();
        return $this->successResponse($industry);
    }
}
