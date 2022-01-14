<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TemplateRequest;
use App\Models\InvoiceTemplate;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class InvoiceTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            InvoiceTemplate::query()
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
            InvoiceTemplate::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param InvoiceTemplate $invoiceTemplate
     * @return JsonResponse|Response|object
     */
    public function show(InvoiceTemplate $invoiceTemplate)
    {
        return $this->successResponse(
            $invoiceTemplate->load(
                'industry'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TemplateRequest $request
     * @param InvoiceTemplate $invoiceTemplate
     * @return JsonResponse
     */
    public function update(TemplateRequest $request, InvoiceTemplate $invoiceTemplate)
    {
        $invoiceTemplate->fill($request->validated());
        if ($invoiceTemplate->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $invoiceTemplate->save();

        return $this->successResponse($invoiceTemplate);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InvoiceTemplate $invoiceTemplate
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(InvoiceTemplate $invoiceTemplate)
    {
        $invoiceTemplate->delete();
        return $this->successResponse($invoiceTemplate);
    }
}
