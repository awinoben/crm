<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaleRequest;
use App\Jobs\MailJob;
use App\Models\Sale;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Sale::query()
                ->with([
                    'lead',
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
     * @param SaleRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(SaleRequest $request)
    {
        $sale = Sale::query()
            ->with([
                'lead',
                'company'
            ])
            ->create($request->validated());

        // send email to the lead to make a deal
        dispatch(new MailJob(
            $sale->lead->email,
            $sale->product->name . ' Big Deal(s)',
            $sale->lead->name,
            $request->description,
            URL::signedRoute('confirm.deal', ['id' => $sale->id]),
            '<<< Confirm Deal >>>',
            URL::signedRoute('cancel.deal', ['id' => $sale->id]),
            '<<< Cancel Deal >>>'
        ))->onQueue('emails')->delay(now()->addSeconds(2));

        return $this->successResponse(
            $sale,
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Sale $sale
     * @return JsonResponse|Response|object
     */
    public function show(Sale $sale)
    {
        return $this->successResponse(
            $sale->load(
                'lead',
                'company'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param SaleRequest $request
     * @param Sale $sale
     * @return JsonResponse
     */
    public function update(SaleRequest $request, Sale $sale)
    {
        $sale->fill($request->validated());

        if ($sale->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $sale->save();

        return $this->successResponse($sale);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Sale $sale
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Sale $sale)
    {
        $sale->delete();
        return $this->successResponse($sale);
    }
}
