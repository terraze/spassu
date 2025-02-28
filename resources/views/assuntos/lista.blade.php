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

<script>
document.addEventListener('DOMContentLoaded', function() {
    window.tableHandler = new TableHandler({
        tableId: 'assuntos-table',
        apiUrl: '/api/assuntos',
        resourceName: 'Assunto',
        idField: 'CodAs',
        displayField: 'Descricao',
        editRoute: '/assuntos/cadastro'
    });
});
</script>
@endsection 