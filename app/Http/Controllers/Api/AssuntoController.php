<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ListaAssuntoRequest;
use App\Models\Assunto;

class AssuntoController extends Controller
{
    
    /**
     * Retorna todos os assuntos
     */
    public function index(ListaAssuntoRequest $request)
    {    
        // Obter parâmetros de ordenação ou usar valores padrão
        $sortField = $request->input('ordenarCampo', 'CodAs');
        $sortDirection = $request->input('ordenarDirecao', 'asc');

        // Obter dados ordenados
        $assuntos = Assunto::orderBy($sortField, $sortDirection)->get();

        return response()->json($assuntos);
    }
}
