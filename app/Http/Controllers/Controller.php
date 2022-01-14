<?php

namespace App\Http\Controllers;

use App\Traits\NodeResponse;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, NodeResponse;

    /** TODO Remember to review the TLL time
     * Add this method to the Controller class
     * @param $token
     * @return JsonResponse
     */
    protected function respondWithToken($token)
    {
        return $this->successResponse(
            [
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => (auth()->guard('api')->factory()->getTTL() * 60) // expires 1hr
            ],
            Response::HTTP_OK
        );
    }
}
