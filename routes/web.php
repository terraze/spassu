<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Listagem de dados
Route::get('/livros', function () {
    return view('livros');
});

Route::get('/autores', function () {
    return view('autores');
});

Route::get('/assuntos', function () {
    return view('assuntos');
});

// Cadastro de dados (edição, criação, remoção)
Route::get('/livros/cadastro', function () {
    return view('livros.cadastro');
});

Route::get('/autores/cadastro', function () {
    return view('autores.cadastro');
});

Route::get('/assuntos/cadastro', function () {
    return view('assuntos.cadastro');
});
