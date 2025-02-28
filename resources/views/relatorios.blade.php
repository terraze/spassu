@extends('app')

@section('content')
<div class="container">
    <h1 class="mb-4">Relatórios</h1>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Relatório 1</h5>
                    <p class="card-text">Lista livros por edição mais recente</p>
                    <a href="{{ route('relatorios.livros') }}" class="btn btn-success">
                        Visualizar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Relatório 2</h5>
                    <p class="card-text">Dados agregados por assunto</p>
                    <a href="{{ route('relatorios.assuntos') }}" class="btn btn-success">
                        Visualizar
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Relatório 3</h5>
                    <p class="card-text">Dados agregados por autor</p>
                    <a href="{{ route('relatorios.autores') }}" class="btn btn-success">
                        Visualizar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 