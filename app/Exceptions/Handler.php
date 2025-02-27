<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    // ... existing code ...

    public function render($request, Throwable $exception)
    {
        if ($request->is('api/*')) {
            if ($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint not found',
                    'data' => null
                ], 404);
            }

            // Handle other types of exceptions
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'data' => null
            ], 500);
        }

        return parent::render($request, $exception);
    }
} 