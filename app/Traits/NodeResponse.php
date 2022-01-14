<?php


namespace App\Traits;


use App\Http\Resources\API;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

trait NodeResponse
{
    /**
     * success response
     * @param $data
     * @param int $code
     * @return JsonResponse|object
     */
    public function successResponse($data, $code = Response::HTTP_OK)
    {
        if (method_exists($data, 'links')) {
            return API::collection($data)
                ->additional([
                    'success' => true
                ])
                ->response()
                ->setStatusCode($code);
        }

        if ($data instanceof Collection) {
            return API::collection($data)
                ->additional([
                    'success' => true
                ])
                ->response()
                ->setStatusCode($code);
        }

        // proceed
        return (new API($data))
            ->additional([
                'success' => true
            ])
            ->response()
            ->setStatusCode($code);
    }


    /**
     * success response
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    public function errorResponse($message, $code)
    {
        return (new API([
            'message' => $message
        ]))->additional([
            'success' => false,
        ])->response()->setStatusCode($code);
    }
}
