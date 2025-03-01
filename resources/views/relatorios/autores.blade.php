@extends('app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Relatório por Autores</h1>
        <a href="{{ route('relatorios') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="alert alert-info mb-4">
                Esta tabela mostra dados agregados por autor, incluindo total de livros, preços médio/máximo/mínimo,
                colaborações com outros autores, total de assuntos e primeiro livro publicado.
            </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Autor</th>
                            <th>Total de Livros</th>
                            <th>Preço Médio</th>
                            <th>Livro Mais Caro</th>
                            <th>Livro Mais Barato</th>
                            <th>Colaborações</th>
                            <th>Assuntos</th>
                            <th>Primeiro Livro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($autores as $autor)
                        <tr>
                            <td>{{ $autor->Nome }}</td>
                            <td>{{ $autor->TotalLivros }}</td>
                            <td>R$ {{ number_format((float)$autor->PrecoMedio, 2, ',', '.') }}</td>
                            <td>
                                {{ $autor->TituloMaisCaro ?: '-' }}
                                @if($autor->TituloMaisCaro)
                                    <br><small class="text-muted">R$ {{ number_format((float)$autor->TituloMaisCaro, 2, ',', '.') }}</small>
                                @endif
                            </td>
                            <td>
                                {{ $autor->TituloMaisBarato ?: '-' }}
                                @if($autor->TituloMaisBarato)
                                    <br><small class="text-muted">R$ {{ number_format((float)$autor->TituloMaisBarato, 2, ',', '.') }}</small>
                                @endif
                            </td>
                            <td>{{ $autor->TotalColaboradores }}</td>
                            <td>{{ $autor->TotalAssuntos }}</td>
                            <td>{{ $autor->PrimeiroLivro ?: '-' }}</td>
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