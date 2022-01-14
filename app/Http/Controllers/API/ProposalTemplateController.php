<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use App\Models\ProposalTemplate;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProposalTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            ProposalTemplate::query()
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
            ProposalTemplate::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param ProposalTemplate $proposalTemplate
     * @return JsonResponse|Response|object
     */
    public function show(ProposalTemplate $proposalTemplate)
    {
        return $this->successResponse(
            $proposalTemplate->load(
                'industry'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TemplateRequest $request
     * @param ProposalTemplate $proposalTemplate
     * @return JsonResponse
     */
    public function update(TemplateRequest $request, ProposalTemplate $proposalTemplate)
    {
        $proposalTemplate->fill($request->validated());
        if ($proposalTemplate->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $proposalTemplate->save();

        return $this->successResponse($proposalTemplate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ProposalTemplate $proposalTemplate
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(ProposalTemplate $proposalTemplate)
    {
        $proposalTemplate->delete();
        return $this->successResponse($proposalTemplate);
    }
}
