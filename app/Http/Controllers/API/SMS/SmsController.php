<?php

namespace App\Http\Controllers\API\SMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendSmsRequest;
use App\Services\SendSmsService;
use App\SMS\SendSms;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class SmsController extends Controller
{
    /**
     * @var SendSmsService
     */
    private $sendSmsService;

    /**
     * instance of the controller
     * @param SendSmsService $sendSmsService
     */
    public function __construct(SendSmsService $sendSmsService)
    {
        $this->sendSmsService = $sendSmsService;
    }

    /**
     * send sms
     * @param string $phone_number
     * @param string $message
     * @return JsonResponse|object
     */
    public function send(string $phone_number, string $message)
    {
        return $this->sendSmsService->send([
            (object)[
                "sender" => config('sms.keys.sender'),
                "message" => $message,
                "phone" => $phone_number,
                "correlator" => Str::random(8),
                "endpoint" => route('sms.call.back'),
            ]
        ]);
    }
}
