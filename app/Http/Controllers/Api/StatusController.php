<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class StatusController extends Controller
{
    /**
     * Retorna o status da aplicação
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try{
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erro ao obter status',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}