<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class BaseApiController extends Controller
{
    /**
     * پاسخ استاندارد API
     */
    protected function apiResponse(
        int   $status = 200,
        string $message = null ,
               $data = null ,

    ): JsonResponse
    {
        return response()->json([
            'message' => $message ?? null,
            'data' => $data ?? null,
        ], $status);
    }
}
