@extends('app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ isset($livro) ? 'Editar' : 'Novo' }} Livro</h1>
        <a href="{{ route('livros.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Voltar
        </a>
    </div>

    <form id="form-livro" class="row g-3">
        @if(isset($livro))
            <input type="hidden" name="CodL" value="{{ $livro->CodL }}">
        @endif

        <div class="col-md-12">
            <label for="Titulo" class="form-label">Título</label>
            <div class="form-group">
                <input type="text" 
                       class="form-control" 
                       id="Titulo" 
                       name="Titulo" 
                       required
                       value="{{ $livro->Titulo ?? '' }}"
                >
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-6">
            <label for="Editora" class="form-label">Editora</label>
            <div class="form-group">
                <input type="text" 
                       class="form-control" 
                       id="Editora" 
                       name="Editora" 
                       required
                       value="{{ $livro->Editora ?? '' }}"
                >
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-2">
            <label for="Edicao" class="form-label">Edição</label>
            <div class="form-group">
                <input type="number" 
                       class="form-control" 
                       id="Edicao" 
                       name="Edicao" 
                       required
                       min="1"
                       value="{{ $livro->Edicao ?? '' }}"
                >
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-2">
            <label for="AnoPublicacao" class="form-label">Ano</label>
            <div class="form-group">
                <input type="number" 
                       class="form-control" 
                       id="AnoPublicacao" 
                       name="AnoPublicacao" 
                       required
                       min="1900"
                       max="{{ date('Y') }}"
                       value="{{ $livro->AnoPublicacao ?? '' }}"
                >
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-2">
            <label for="Preco" class="form-label">Preço</label>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-text">R$</span>
                    <input type="number" 
                           class="form-control" 
                           id="Preco" 
                           name="Preco" 
                           required
                           min="0"
                           step="0.01"
                           value="{{ $livro->Preco ?? '' }}"
                    >
                    <div class="invalid-feedback"></div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <label for="Autores" class="form-label">Autores</label>
            <div class="form-group">
                <select class="form-select" 
                        id="Autores" 
                        name="Autores[]" 
                        multiple 
                >
                    @foreach($autores as $autor)
                        <option value="{{ $autor->CodAu }}"
                            {{ isset($livro) && $livro->autores->contains($autor->CodAu) ? 'selected' : '' }}
                        >
                            {{ $autor->Nome }}
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback"></div>
            </div>
        </div>

        <div class="col-md-6">
            <label for="Assuntos" class="form-label">Assuntos</label>
            <div class="form-group">
                <select class="form-select" 
                        id="Assuntos" 
                        name="Assuntos[]" 
                        multiple 
                >
                    @foreach($assuntos as $assunto)
                        <option value="{{ $assunto->CodAs }}"
                            {{ isset($livro) && $livro->assuntos->contains($assunto->CodAs) ? 'selected' : '' }}
                        >
                            {{ $assunto->Descricao }}
                        </option>
                    @endforeach
                </select>
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
    formId: 'form-livro',
    apiUrl: '/api/livros',
    idField: 'CodL',
    successRedirect: '{{ route("livros.index") }}'
});
</script>
@endpush
@endsection