@extends('app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Relatório por Autor</h1>
        <a href="{{ route('relatorios') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <!-- Conteúdo do relatório será adicionado aqui -->
        </div>
    </div>
</div>
@endsection 