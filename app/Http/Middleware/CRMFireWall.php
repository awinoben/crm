<?php

namespace App\Http\Middleware;

use App\Traits\NodeResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class CRMFireWall
{
    use NodeResponse;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // checks if the authorized user is admin
        if (auth('api')->check()) {
            $request->user()->load('role');
            if ($request->user()->load('role')->role->slug === Str::slug(config('crm-roles.admin')))
                return $next($request);
            return $this->errorResponse(
                'You are not authorized to perform any action.',
                Response::HTTP_UNAUTHORIZED
            );
        }
    }
}
