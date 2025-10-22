<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    /**
     * پاسخ استاندارد API
     */
    protected function apiResponse(
        bool   $status,
        string $message = '',
               $data = null,
        int    $statusCode = 200,
        string $next = null
    ): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'message' => $message ?? '',
            'data' => $data ?? null,
            'next_route' => $next,
            'timestamp' => now(),
        ], $statusCode);
    }
}
