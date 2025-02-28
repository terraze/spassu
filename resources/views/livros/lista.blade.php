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
<script src="{{ asset('js/data-table.js') }}"></script>
<script>
let dataTable;

document.addEventListener('DOMContentLoaded', function() {
    dataTable = new DataTable('livros-table', {
        apiUrl: '/api/livros',
        sortField: 'CodL',
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
                        <button class="btn btn-sm btn-primary" onclick="editarLivro(${livro.CodL})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="excluirLivro(${livro.CodL}, '${livro.Titulo}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });
});

function editarLivro(id) {
    window.location.href = `/livros/cadastro/${id}`;
}

function excluirLivro(id, titulo) {
    if (confirm(`Tem certeza que deseja excluir o livro "${titulo}"?`)) {
        axios.delete(`/api/livros/${id}`)
            .then(response => {
                if (response.status === 200) {
                    Toast.show('Livro excluído com sucesso!', 'success');
                    dataTable.loadData();
                }
            })
            .catch(error => {
                console.error('Erro ao excluir livro:', error);
                let mensagem = 'Erro ao excluir o livro.';
                
                if (error.response?.status === 404) {
                    mensagem = 'Livro não encontrado.';
                } else if (error.response?.data?.message) {
                    mensagem = error.response.data.message;
                }
                
                Toast.show(mensagem, 'error');
            });
    }
}
</script>
@endpush
@endsection