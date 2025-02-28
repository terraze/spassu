@extends('app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Relatório por Livros</h1>
        <a href="{{ route('relatorios') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info mb-4">
                Esta tabela mostra a última edição de cada livro, o total de edições e demais dados daquela edição,
                bem como os assuntos e autores associados a cada livro. Ordenado por Título.
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Editora</th>
                            <th>Edição Atual</th>
                            <th>Total Edições</th>
                            <th>Preço</th>
                            <th>Ano</th>
                            <th>Assuntos</th>
                            <th>Autores</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($livros as $livro)
                        <tr>
                            <td>{{ $livro->Titulo }}</td>
                            <td>{{ $livro->Editora }}</td>
                            <td>{{ $livro->EdicaoAtual }}</td>
                            <td>{{ $livro->TotalEdicoes }}</td>
                            <td>R$ {{ number_format($livro->Preco, 2, ',', '.') }}</td>
                            <td>{{ $livro->AnoPublicacao }}</td>
                            <td>{{ $livro->Assuntos ?: '-' }}</td>
                            <td>{{ $livro->Autores ?: '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                <button class="btn btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#sqlDefinition">
                    Ver definição SQL da view
                </button>
                <div class="collapse mt-2" id="sqlDefinition">
                    <div class="card card-body bg-light">
                        <pre class="mb-0">{!! $viewDefinition !!}</pre>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 