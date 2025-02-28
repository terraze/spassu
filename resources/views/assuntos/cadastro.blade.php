@extends('app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ isset($assunto) ? 'Editar' : 'Novo' }} Assunto</h1>
        <a href="{{ route('assuntos.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <form id="form-assunto" class="row g-3">
        @if(isset($assunto))
            <input type="hidden" name="CodAs" value="{{ $assunto->CodAs }}">
        @endif

        <div class="col-md-12">
            <label for="Descricao" class="form-label">Descrição</label>
            <div class="form-group">
                <input type="text" 
                       class="form-control" 
                       id="Descricao" 
                       name="Descricao" 
                       required                       
                       value="{{ $assunto->Descricao ?? '' }}"
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
    formId: 'form-assunto',
    apiUrl: '/api/assuntos',
    idField: 'CodAs',
    successRedirect: '{{ route("assuntos.index") }}'
});
</script>
@endpush
@endsection