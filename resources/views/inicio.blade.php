@extends('app')

@section('content')
<div class="container">
    <h1 class="mb-4">Sistema de Gerenciamento de Livros</h1>

    <div class="alert alert-info mb-4">
        <h4 class="alert-heading">Notas Importantes:</h4>
        <ul class="mb-0">
            <li>Por se tratar de formulários que enviam todos os campos, optei por usar o método PUT ao invés de PATCH nas atualizações via API</li>
            <li>A associações de livros com autores e assuntos são feitas pelo cadastro de Livro</li>
            <li>Deleções não ocorrem em cascata, mas sempre que um registro é removido o sistema remove suas associação antes, mantendo os dados das outras tabelas</li>
            <li>Não há validações de duplicidade</li>
        </ul>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Livros</h5>
                    <p class="card-text">Gerencie o cadastro de livros</p>
                    <a href="{{ route('livros.index') }}" class="btn btn-primary">
                        Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Autores</h5>
                    <p class="card-text">Gerencie o cadastro de autores</p>
                    <a href="{{ route('autores.index') }}" class="btn btn-primary">
                        Acessar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Assuntos</h5>
                    <p class="card-text">Gerencie o cadastro de assuntos</p>
                    <a href="{{ route('assuntos.index') }}" class="btn btn-primary">
                        Acessar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="text-center mt-5">
        <a href="{{ route('relatorios') }}" class="btn btn-lg btn-outline-primary">
            <i class="bi bi-file-earmark-bar-graph"></i> Acessar Relatórios
        </a>
    </div>
</div>
@endsection
