<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Note\Models\Notification as NotificationAlias;
use Note\Note;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse|Response|object
     */
    public function index()
    {
        return $this->successResponse(
            Note::latestNotifications()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param NotificationAlias $notification
     * @return JsonResponse|Response|object
     */
    public function show(NotificationAlias $notification)
    {
        return $this->successResponse(
            $notification->update([
                'status' => true
            ])
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param NotificationAlias $notification
     * @return Response
     */
    public function update(Request $request, NotificationAlias $notification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param NotificationAlias $notification
     * @return JsonResponse|Response|object
     * @throws \Exception
     */
    public function destroy(NotificationAlias $notification)
    {
        $notification->delete();
        return $this->successResponse(
            $notification
        );
    }
}
