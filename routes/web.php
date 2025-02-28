<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LivroController;
use App\Http\Controllers\AutorController;
use App\Http\Controllers\AssuntoController;

Route::get('/', function () {
    return view('inicio');
});

// Listagem de dados
Route::get('/livros', [LivroController::class, 'index'])->name('livros.index');
Route::get('/autores', [AutorController::class, 'index'])->name('autores.index');
Route::get('/assuntos', [AssuntoController::class, 'index'])->name('assuntos.index');

// Cadastro de dados (edição e criação)
Route::get('/livros/cadastro/{id?}', [LivroController::class, 'cadastro'])->name('livros.cadastro');
Route::get('/autores/cadastro/{id?}', [AutorController::class, 'cadastro'])->name('autores.cadastro');
Route::get('/assuntos/cadastro/{id?}', [AssuntoController::class, 'cadastro'])->name('assuntos.cadastro');

// Relatórios
Route::prefix('relatorios')->group(function () {
    Route::get('/', function () {
        return view('relatorios');
    })->name('relatorios');

    Route::get('/livros', function () {
        return view('relatorios.livros');
    })->name('relatorios.livros');

    Route::get('/assuntos', function () {
        return view('relatorios.assuntos');
    })->name('relatorios.assuntos');

    Route::get('/autores', function () {
        return view('relatorios.autores');
    })->name('relatorios.autores');
});
