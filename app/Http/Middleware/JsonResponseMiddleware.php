<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class JsonResponseMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Force Accept header to application/json
        $request->headers->set('Accept', 'application/json');

        // Get the response
        $response = $next($request);

        // If the response is not already a JSON response, convert it
        if (!$response->headers->get('Content-Type') || !str_contains($response->headers->get('Content-Type'), 'application/json')) {
            $data = [
                'success' => $response->isSuccessful(),
                'message' => $response->statusText(),
                'data' => $response->getContent()
            ];

            return response()->json($data, $response->status());
        }

        return $response;
    }
} 