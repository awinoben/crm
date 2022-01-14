<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;


class RefreshAccessToken extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return JsonResponse
     */
    public function __invoke(): JsonResponse
    {
        // TODO: This one also works return auth('api')->refresh(true,true);
        return $this->respondWithToken(auth()->guard('api')->refresh());
    }
}
