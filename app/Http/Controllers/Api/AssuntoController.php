<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Assunto;

use Illuminate\Http\Request;

class AssuntoController extends Controller
{
    /**
     * Retorna todos os assuntos
     */
    public function index()
    {
        return response()->json(Assunto::all());
    }
}
