<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AutorController extends Controller
{
    public function index()
    {
        return view('autores.lista');
    }

    public function cadastro()
    {
        return view('autores.cadastro');
    }
}
