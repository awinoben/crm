<?php


namespace App\Services;


use App\Traits\NodeResponse;
use App\Traits\ProcessingGate;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class SendSmsService
{
    use NodeResponse, ProcessingGate;

    /**
     * @var Application|mixed
     */
    private $baseUri;

    /**
     * set class instance
     */
    public function __construct()
    {
        $this->baseUri = config('sms.url.endpoint');
    }

    /**
     * send sms
     * @param array $options
     * @return JsonResponse|object
     */
    public function send(array $options)
    {
        try {
            $response = json_decode($this->processRequest(config('sms.url.send-sms'), $options, 'POST'));
            if ($response->status)
                return $this->successResponse(Response::HTTP_OK);
            return $this->errorResponse('Failed to send sms.', Response::HTTP_NOT_ACCEPTABLE);
        } catch (Exception $exception) {
            return $this->errorResponse('Failed to send sms.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
