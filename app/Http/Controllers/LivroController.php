<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LivroController extends Controller
{
    public function index()
    {
        return view('livros.lista');
    }

    public function cadastro()
    {
        return view('livros.cadastro');
    }
}
