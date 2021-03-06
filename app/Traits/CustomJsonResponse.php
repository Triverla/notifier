<?php


namespace App\Traits;


use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

trait CustomJsonResponse
{
    public function successResponse(string $message, array $data = []): JsonResponse
    {

        $response = [
            'status' => true,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, Response::HTTP_OK);
    }

    public function failedResponse(string $message = null, array $data = []): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Set form validation errors
     *
     * @param $errors
     * @param array $data
     * @return JsonResponse
     */
    public function formValidationResponse($errors, array $data = []): JsonResponse
    {
        $response = [
            'status' => false,
            'message' => 'Whoops. Validation failed',
            'validationErrors' => $errors,
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function serverErrorResponse(string $message, \Exception $exception = null): JsonResponse
    {
        if ($exception !== null) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = [
            'status' => false,
            'message' => $message
        ];

        return response()->json($response, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
