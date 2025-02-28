@extends('app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Livros</h1>
    <a href="{{ route('livros.cadastro') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Livro
    </a>
</div>

@component('components.table', [
    'tableId' => 'livros-table',
    'headers' => [
        ['label' => 'Código', 'field' => 'CodL'],
        ['label' => 'Título', 'field' => 'Titulo'],
        ['label' => 'Editora', 'field' => 'Editora'],
        ['label' => 'Edição', 'field' => 'Edicao'],
        ['label' => 'Ano', 'field' => 'AnoPublicacao'],
        ['label' => 'Preço', 'field' => 'Preco'],
        ['label' => 'Ações', 'field' => null]
    ]
])
@endcomponent

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.tableHandler = new TableHandler({
        tableId: 'livros-table',
        apiUrl: '/api/livros',
        resourceName: 'Livro',
        idField: 'CodL',
        displayField: 'Titulo',
        editRoute: '/livros/cadastro',
        rowTemplate: (livro) => {
            return `
                <tr>
                    <td>${livro.CodL}</td>
                    <td>${livro.Titulo}</td>
                    <td>${livro.Editora}</td>
                    <td>${livro.Edicao}</td>
                    <td>${livro.AnoPublicacao}</td>
                    <td>R$ ${Number(livro.Preco).toFixed(2)}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="tableHandler.edit(${livro.CodL})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="tableHandler.delete(${livro.CodL}, '${livro.Titulo}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });
});
</script>
@endpush
@endsection