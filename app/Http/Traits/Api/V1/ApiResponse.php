<?php

namespace App\Http\Traits\Api\V1;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected function successResponse( $data = [] , string $message = 'Success',  $statuscode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'Success',
            'message' => $message,
            'data' => $data,
        ], $statuscode);
    }

    protected function errorResponse( $errors = [], string $message = 'Error',  $statuscode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'Error',
            'message' => $message,
            'errors' => $errors,
        ], $statuscode);
    }
}
