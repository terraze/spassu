<?php

namespace App\Http\Controllers;

use App\Models\Livro;
use App\Models\Autor;
use App\Models\Assunto;

class LivroController extends Controller
{
    /**
     * Página de lista de livros
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('livros.lista');
    }

    /**
     * Página de cadastro de livro (contém associação com autores e assuntos)
     * 
     * @param int|null $id
     * @return \Illuminate\View\View
     */
    public function cadastro($id = null)
    {
        $livro = null;
        if ($id) {
            $livro = Livro::with(['autores', 'assuntos'])->findOrFail($id);
        }
        
        $autores = Autor::orderBy('Nome')->get();
        $assuntos = Assunto::orderBy('Descricao')->get();
        
        return view('livros.cadastro', compact('livro', 'autores', 'assuntos'));
    }
}
