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
    @slot('row_template')
        <tr>
            <td>@{{ CodAs }}</td>
            <td>@{{ Descricao }}</td>
            <td>
                <button class="btn btn-sm btn-primary" onclick="editarAssunto(@{{ CodAs }})">
                    <i class="bi bi-pencil"></i>
                </button>
                <button class="btn btn-sm btn-danger" onclick="excluirAssunto(@{{ CodAs }})">
                    <i class="bi bi-trash"></i>
                </button>
            </td>
        </tr>
    @endslot
@endcomponent

@push('scripts')
<script src="{{ asset('js/data-table.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = new DataTable('assuntos-table', {
        apiUrl: '/api/assuntos',
        sortField: 'CodAs',
        rowTemplate: (assunto) => {
            const template = document.querySelector('#assuntos-table-row-template').innerHTML;
            return template.replace(/@{{(.*?)}}/g, (match, key) => assunto[key.trim()]);
        }
    });
});

function editarAssunto(id) {
    window.location.href = `/assuntos/cadastro/${id}`;
}

function excluirAssunto(id) {
    if (confirm('Tem certeza que deseja excluir este assunto?')) {
        axios.delete(`/api/assuntos/${id}`)
            .then(response => {
                if (response.status === 200) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Erro ao excluir assunto:', error);
                alert('Erro ao excluir o assunto.');
            });
    }
}
</script>
@endpush
@endsection 