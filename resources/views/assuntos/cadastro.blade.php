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
document.getElementById('form-assunto').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = Object.fromEntries(formData);
    
    LoadingOverlay.show();
    
    const method = data.CodAs ? 'PUT' : 'POST';
    const url = data.CodAs ? `/api/assuntos/${data.CodAs}` : '/api/assuntos';
    
    axios({
        method,
        url,
        data
    })
    .then(response => {
        Toast.show('Assunto salvo com sucesso!', 'success');
        window.location.href = '{{ route("assuntos.index") }}';
    })
    .catch(error => {
        console.error('Erro ao salvar assunto:', error);
        
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
            Toast.show('Erro ao salvar assunto. Tente novamente.', 'error');
        }
    })
    .finally(() => {
        LoadingOverlay.hide();
    });
});
</script>
@endpush
@endsection