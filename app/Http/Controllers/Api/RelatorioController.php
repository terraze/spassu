<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RelatorioController extends Controller
{
    /**
     * Retorna os dados do relatório de livros
     * 
     * @return JsonResponse
     */
    public function livros(): JsonResponse
    {
        $livros = DB::table('livro_report_view')->get();
        
        return response()->json($livros);
    }
} 