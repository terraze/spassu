@extends('app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Autores</h1>
    <a href="{{ route('autores.cadastro') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Autor
    </a>
</div>

@component('components.table', [
    'tableId' => 'autores-table',
    'headers' => [
        ['label' => 'Código', 'field' => 'CodAu'],
        ['label' => 'Nome', 'field' => 'Nome'],
        ['label' => 'Ações', 'field' => null]
    ]
])
@endcomponent

@push('scripts')
<script src="{{ asset('js/data-table.js') }}"></script>
<script>
let dataTable;

document.addEventListener('DOMContentLoaded', function() {
    dataTable = new DataTable('autores-table', {
        apiUrl: '/api/autores',
        sortField: 'CodAu',
        rowTemplate: (autor) => {
            return `
                <tr>
                    <td>${autor.CodAu}</td>
                    <td>${autor.Nome}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editarAutor(${autor.CodAu})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="excluirAutor(${autor.CodAu}, '${autor.Nome}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });
});

function editarAutor(id) {
    window.location.href = `/autores/cadastro/${id}`;
}

function excluirAutor(id, nome) {
    if (confirm(`Tem certeza que deseja excluir o autor "${nome}"?`)) {
        axios.delete(`/api/autores/${id}`)
            .then(response => {
                if (response.status === 200) {
                    Toast.show('Autor excluído com sucesso!', 'success');
                    dataTable.loadData();
                }
            })
            .catch(error => {
                console.error('Erro ao excluir autor:', error);
                let mensagem = 'Erro ao excluir o autor.';
                
                if (error.response?.status === 404) {
                    mensagem = 'Autor não encontrado.';
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