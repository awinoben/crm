<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Traits\NodeResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Product::query()
                ->with([
                    'company',
                    'sale'
                ])
                ->where('company_id', request()->user()->company_id)
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(ProductRequest $request)
    {
        return $this->successResponse(
            Product::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse|Response|object
     */
    public function show(Product $product)
    {
        return $this->successResponse(
            $product->load('company', 'sale')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->fill($request->validated());

        if ($product->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $product->save();

        return $this->successResponse($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return $this->successResponse($product);
    }
}
