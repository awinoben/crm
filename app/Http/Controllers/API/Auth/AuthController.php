<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param AuthRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = auth()->guard('api')->attempt($credentials)) {
            // pass the data companies details here to assign user a company automatically
            if (is_null(auth()->guard('api')->user()->comapny_id))
                auth()->guard('api')->user()->update([
                    'company_id' => auth()->guard('api')->user()->load('companies')->companies()->first()->id
                ]);

            // Authentication passed respond back with bearer token...
            return $this->respondWithToken($token);
        }

        return $this->errorResponse('Wrong credentials.', Response::HTTP_UNAUTHORIZED);
    }
}
