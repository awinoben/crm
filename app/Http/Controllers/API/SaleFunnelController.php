<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleFunnelRequest;
use App\Models\SaleFunnel;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SaleFunnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            SaleFunnel::query()
                ->with([
                    'lead',
                    'company',
                    'social_insight',
                    'tip'
                ])
                ->where('company_id', request()->user()->company_id)
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SaleFunnelRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(SaleFunnelRequest $request)
    {
        return $this->successResponse(
            SaleFunnel::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param SaleFunnel $saleFunnel
     * @return JsonResponse|Response|object
     */
    public function show(SaleFunnel $saleFunnel)
    {
        return $this->successResponse(
            $saleFunnel->load(
                'lead',
                'company',
                'social_insight',
                'tip'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaleFunnelRequest $request
     * @param SaleFunnel $saleFunnel
     * @return JsonResponse
     */
    public function update(SaleFunnelRequest $request, SaleFunnel $saleFunnel)
    {
        $saleFunnel->fill($request->validated());

        if ($saleFunnel->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $saleFunnel->save();

        return $this->successResponse($saleFunnel);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SaleFunnel $saleFunnel
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(SaleFunnel $saleFunnel)
    {
        $saleFunnel->delete();
        return $this->successResponse($saleFunnel);
    }
}
