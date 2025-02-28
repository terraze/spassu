@extends('app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Lista de Assuntos</h1>
    <a href="{{ route('assuntos.cadastro') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg"></i> Novo Assunto
    </a>
</div>

@component('components.table', [
    'tableId' => 'assuntos-table',
    'headers' => [
        ['label' => 'Código', 'field' => 'CodAs'],
        ['label' => 'Descrição', 'field' => 'Descricao'],
        ['label' => 'Ações', 'field' => null]
    ]
])
@endcomponent

@push('scripts')
<script src="{{ asset('js/data-table.js') }}"></script>
<script>
let dataTable;

document.addEventListener('DOMContentLoaded', function() {
    dataTable = new DataTable('assuntos-table', {
        apiUrl: '/api/assuntos',
        sortField: 'CodAs',
        rowTemplate: (assunto) => {
            return `
                <tr>
                    <td>${assunto.CodAs}</td>
                    <td>${assunto.Descricao}</td>
                    <td>
                        <button class="btn btn-sm btn-primary" onclick="editarAssunto(${assunto.CodAs})">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="excluirAssunto(${assunto.CodAs}, '${assunto.Descricao}')">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        }
    });
});

function editarAssunto(id) {
    window.location.href = `/assuntos/cadastro/${id}`;
}

function excluirAssunto(id, descricao) {
    if (confirm(`Tem certeza que deseja excluir o assunto "${descricao}"?`)) {
        axios.delete(`/api/assuntos/${id}`)
            .then(response => {
                if (response.status === 200) {
                    Toast.show('Assunto excluído com sucesso!', 'success');
                    dataTable.loadData();
                }
            })
            .catch(error => {
                console.error('Erro ao excluir assunto:', error);
                let mensagem = 'Erro ao excluir o assunto.';
                
                if (error.response?.status === 404) {
                    mensagem = 'Assunto não encontrado.';
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