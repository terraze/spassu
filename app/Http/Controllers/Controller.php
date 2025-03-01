<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;

abstract class Controller
{
    /**
     * Limpa o cache de relatórios
     * @return void
     */
    protected function limparCache()
    {
        Cache::forget('relatorio.livros');
        Cache::forget('relatorio.assuntos');
        Cache::forget('relatorio.autores');
    }
}
