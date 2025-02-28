<?php

namespace App\Http\Requests\Api;

class ListaAutorRequest extends ListaRequest
{
    /**
     * Lista de campos disponíveis para ordenação
     * @return array
     */
    protected function getSortFields(): array
    {
        return ['CodAu', 'Nome'];
    } 
} 