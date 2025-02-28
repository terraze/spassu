<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assunto;

class AssuntoController extends Controller
{
    /**
     * Página de lista de assuntos
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('assuntos.lista');
    }

    /**
     * Página de cadastro de assunto
     * @param int|null $id
     * @return \Illuminate\View\View
     */
    public function cadastro($id = null)
    {
        $assunto = null;
        if ($id) {
            $assunto = Assunto::findOrFail($id);
        }
        
        return view('assuntos.cadastro', compact('assunto'));
    }
}
