<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceJsonResponce
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // اجباری کردن اینکه درخواست همیشه JSON قبول کند
        $request->headers->set('Accept', 'application/json');

        $response = $next($request);

        // اگر پاسخ از نوع JSON نیست (مثلاً HTML یا redirect)
        if (!$response->headers->has('Accept') ||
            !str_contains($response->headers->get('Accept'), 'application/json')) {

            // تبدیل به JSON ساختاریافته
            $response = response()->json([
                'message' => $response->getOriginalContent() ?? 'Non‑JSON response converted',
                'status_code' => $response->getStatusCode(),
            ], $response->getStatusCode());
        }

        return $response;
    }
}
