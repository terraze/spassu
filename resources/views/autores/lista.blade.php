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
<script>
document.addEventListener('DOMContentLoaded', function() {
    window.tableHandler = new TableHandler({
        tableId: 'autores-table',
        apiUrl: '/api/autores',
        resourceName: 'Autor',
        idField: 'CodAu',
        displayField: 'Nome',
        editRoute: '/autores/cadastro'
    });
});
</script>
@endpush
@endsection 