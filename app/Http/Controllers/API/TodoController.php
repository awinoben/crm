<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TodoRequest;
use App\Models\Todo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Todo::query()
                ->with([
                    'company',
                    'user'
                ])
                ->where('company_id', request()->user()->company_id)
                ->latest()
                ->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TodoRequest $request
     * @return JsonResponse|Response|object
     */
    public function store(TodoRequest $request)
    {
        return $this->successResponse(
            Todo::query()->create($request->validated()),
            Response::HTTP_CREATED
        );
    }

    /**
     * Display the specified resource.
     *
     * @param Todo $todo
     * @return JsonResponse|Response|object
     */
    public function show(Todo $todo)
    {
        return $this->successResponse(
            $todo->load(
                'company',
                'user'
            )
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param TodoRequest $request
     * @param Todo $todo
     * @return JsonResponse
     */
    public function update(TodoRequest $request, Todo $todo)
    {
        $todo->fill($request->validated());

        if ($todo->isClean()) {
            return $this->errorResponse('At least one value must change.', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $todo->save();

        return $this->successResponse($todo);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Todo $todo
     * @return JsonResponse|Response|object
     * @throws Exception
     */
    public function destroy(Todo $todo)
    {
        $todo->delete();
        return $this->successResponse($todo);
    }
}
