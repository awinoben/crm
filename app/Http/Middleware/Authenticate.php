<?php

namespace App\Http\Middleware;

use App\Traits\NodeResponse;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    use NodeResponse;

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return $this->errorResponse('Unauthorized', Response::HTTP_UNAUTHORIZED);
        }
    }
}
