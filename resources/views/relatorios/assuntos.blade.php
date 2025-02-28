@extends('app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Relatório por Assunto</h1>
        <a href="{{ route('relatorios') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info mb-4">
                Esta tabela mostra dados agregados por assunto e editora, incluindo
                total de livros (títulos únicos) e total de edições para cada combinação.
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Assunto</th>
                            <th>Editora</th>
                            <th>Total de Livros</th>
                            <th>Total de Edições</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($assuntos as $assunto)
                        <tr>
                            <td>{{ $assunto->Assunto }}</td>
                            <td>{{ $assunto->Editora ?: '-' }}</td>
                            <td>{{ $assunto->TotalLivros }}</td>
                            <td>{{ $assunto->TotalEdicoes }}</td>
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