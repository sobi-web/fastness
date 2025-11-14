<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class UnauthenticatedRenderer extends Exception
{
    public function __invoke(AuthenticationException $e, $request): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthenticated'
        ], 401);
    }
}
