@extends('app')

@section('content')
<div class="text-center">
    <h1 class="display-4 mb-4">Bem-vindo à Biblioteca</h1>
    
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title h4 mb-3">Livros</h2>
                    <p class="card-text mb-3">Explore nossa coleção de livros.</p>
                    <a href="{{ route('livros.index') }}" class="btn btn-primary">Ver Livros</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title h4 mb-3">Autores</h2>
                    <p class="card-text mb-3">Conheça nossos autores.</p>
                    <a href="{{ route('autores.index') }}" class="btn btn-primary">Ver Autores</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title h4 mb-3">Assuntos</h2>
                    <p class="card-text mb-3">Navegue por assuntos.</p>
                    <a href="{{ route('assuntos.index') }}" class="btn btn-primary">Ver Assuntos</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
