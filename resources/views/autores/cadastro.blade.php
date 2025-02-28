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
document.getElementById('form-autor').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    LoadingOverlay.show();
    
    const method = data.CodAu ? 'PUT' : 'POST';
    const url = data.CodAu ? `/api/autores/${data.CodAu}` : '/api/autores';
    
    axios({
        method,
        url,
        data
    })
    .then(response => {
        Toast.show('Autor salvo com sucesso!', 'success');
        window.location.href = '{{ route("autores.index") }}';
    })
    .catch(error => {
        console.error('Erro ao salvar autor:', error);
        
        if (error.response?.status === 400) {
            const errors = error.response.data.errors;
            Object.keys(errors).forEach(field => {
                const input = document.getElementById(field);
                if (input) {
                    input.classList.add('is-invalid');
                    const feedback = input.nextElementSibling;
                    if (feedback && feedback.classList.contains('invalid-feedback')) {
                        feedback.textContent = errors[field][0];
                    }
                }
            });
        } else {
            Toast.show('Erro ao salvar autor. Tente novamente.', 'error');
        }
    })
    .finally(() => {
        LoadingOverlay.hide();
    });
});
</script>
@endpush
@endsection