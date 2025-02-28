<?php

namespace App\Http\Requests\Api;

class ListaLivroRequest extends ListaRequest
{
    /**
     * Lista de campos disponíveis para ordenação
     */
    protected function getSortFields(): array
    {
        return ['CodL', 'Titulo', 'AnoPublicacao', 'Editora', 'Edicao'];
    }
} 