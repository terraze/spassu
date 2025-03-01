@extends('app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h4 class="mb-0">{{ $title ?? 'Erro' }}</h4>
                </div>
                <div class="card-body">
                    <p class="lead">{{ $message ?? 'Ocorreu um erro inesperado.' }}</p>
                    
                    @if(isset($details))
                        <div class="alert alert-secondary">
                            <pre class="mb-0">{{ $details }}</pre>
                        </div>
                    @endif

                    <div class="mt-4">
                        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
