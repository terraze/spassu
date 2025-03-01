<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StatusController;
use App\Http\Controllers\Api\LivroController;
use App\Http\Controllers\Api\AutorController;
use App\Http\Controllers\Api\AssuntoController;
use App\Http\Controllers\Api\RelatorioController;

// Status da API
Route::get('/status', [StatusController::class, 'index']);

// Listagem de dados
Route::get('/livros', [LivroController::class, 'index']);
Route::get('/autores', [AutorController::class, 'index']);
Route::get('/assuntos', [AssuntoController::class, 'index']);

// Detalhamento de dados por ID
Route::get('/livros/{id}', [LivroController::class, 'show']);
Route::get('/autores/{id}', [AutorController::class, 'show']);
Route::get('/assuntos/{id}', [AssuntoController::class, 'show']);

// Criação de dados
Route::post('/livros', [LivroController::class, 'store']);
Route::post('/autores', [AutorController::class, 'store']);
Route::post('/assuntos', [AssuntoController::class, 'store']);

// Atualização de dados
Route::put('/livros/{id}', [LivroController::class, 'update']);
Route::put('/autores/{id}', [AutorController::class, 'update']);
Route::put('/assuntos/{id}', [AssuntoController::class, 'update']);

// Remoção de dados
Route::delete('/livros/{id}', [LivroController::class, 'destroy']);
Route::delete('/autores/{id}', [AutorController::class, 'destroy']);
Route::delete('/assuntos/{id}', [AssuntoController::class, 'destroy']);
