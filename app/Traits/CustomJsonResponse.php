<?php


namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

trait CustomJsonResponse
{
    public function successResponse(string $message, array $data = []): JsonResponse
    {

        $response = [
            'status' => true,
            'statuscode' => Response::HTTP_OK,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, Response::HTTP_OK);
    }

    public function failedResponse(string $message = null, array $data = []): \Illuminate\Http\JsonResponse
    {
        $response = [
            'status' => false,
            'statuscode' => Response::HTTP_BAD_REQUEST,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, Response::HTTP_BAD_REQUEST);
    }

    public function serverErrorResponse(string $message, \Exception $exception = null): \Illuminate\Http\JsonResponse
    {
        if ($exception !== null) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = [
            'status' => false,
            'statuscode' => Response::HTTP_INTERNAL_SERVER_ERROR,
            'message' => $message
        ];

        return Response::json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
