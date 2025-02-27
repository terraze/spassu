<?php

namespace App\Helpers;

use Error;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ApiResponseHelper
{
    public static function handleException(Throwable $e)
    {
        $status = match(true) {
            $e instanceof NotFoundHttpException => 404,
            $e instanceof Error => 500,
            default => 500
        };

        $message = match(true) {
            $e instanceof NotFoundHttpException => 'Endpoint not found',
            $e instanceof Error => 'Internal server error',
            default => $e->getMessage()
        };

        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => config('app.debug') ? [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ] : null
        ], $status);
    }
} 