<?php

namespace App\Http\Controllers;

use App\Models\Autor;

class AutorController extends Controller
{
    /**
     * Página de lista de autores
     */
    public function index()
    {
        return view('autores.lista');
    }

    /**
     * Página de cadastro de autor
     */
    public function cadastro($id = null)
    {
        $autor = null;
        if ($id) {
            $autor = Autor::findOrFail($id);
        }
        
        return view('autores.cadastro', compact('autor'));
    }
}
