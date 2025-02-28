@extends('app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ isset($autor) ? 'Editar' : 'Novo' }} Autor</h1>
        <a href="{{ route('autores.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <form id="form-autor" class="row g-3">
        @if(isset($autor))
            <input type="hidden" name="CodAu" value="{{ $autor->CodAu }}">
        @endif

        <div class="col-md-12">
            <label for="Nome" class="form-label">Nome</label>
            <div class="form-group">
                <input type="text" 
                       class="form-control" 
                       id="Nome" 
                       name="Nome" 
                       required
                       value="{{ $autor->Nome ?? '' }}"
                >
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Salvar
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
new FormHandler({
    formId: 'form-autor',
    apiUrl: '/api/autores',
    idField: 'CodAu',
    successRedirect: '{{ route("autores.index") }}'
});
</script>
@endpush
@endsection