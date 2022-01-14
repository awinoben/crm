<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|object
     */
    public function index()
    {
        return $this->successResponse(
            Role::query()
                ->with([
                    'user'
                ])
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return JsonResponse|object
     */
    public function store(RoleRequest $request)
    {
        return $this->successResponse(
            Role::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return JsonResponse|object
     */
    public function show(Role $role)
    {
        return $this->successResponse(
            $role->load(
                'user'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRoleRequest $request
     * @param Role $role
     * @return JsonResponse
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        $role->fill($request->validated());
        if ($role->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $role->save();

        return $this->successResponse($role);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return JsonResponse|object
     * @throws Exception
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return $this->successResponse($role);
    }
}
