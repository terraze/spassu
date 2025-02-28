<?php

namespace App\Http\Requests\Api;

class ListaAssuntoRequest extends ListaRequest
{
    /**
     * Lista de campos disponíveis para ordenação
     * @return array
     */
    protected function getSortFields(): array
    {
        return ['CodAs', 'Descricao'];
    }
} 