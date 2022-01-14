<?php

namespace App\Http\Controllers\API\FaceBook;

use App\Http\Controllers\Controller;
use App\Services\FaceBookMessengerService;
use Illuminate\Http\JsonResponse;

class MessengerController extends Controller
{
    /**
     * @var FaceBookMessengerService
     */
    private $faceBookMessengerService;

    /**
     * create controller instance here
     * @param FaceBookMessengerService $faceBookMessengerService
     */
    public function __construct(FaceBookMessengerService $faceBookMessengerService)
    {
        $this->faceBookMessengerService = $faceBookMessengerService;
    }

    /**
     * post a basic message/text to
     * messenger
     * @return JsonResponse|object
     */
    public function basicText()
    {
        return $this->successResponse($this->faceBookMessengerService->sendBasicText());
    }
}
