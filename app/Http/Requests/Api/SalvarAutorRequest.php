<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseRequest;
use App\Models\Autor;

class SalvarAutorRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'Nome' => 'required|string|max:' . Autor::MAX_NOME_LENGTH
        ];
    }

    public function messages(): array
    {
        return [
            'Nome.required' => 'O nome é obrigatório',
            'Nome.max' => 'O nome não pode ter mais que ' . Autor::MAX_NOME_LENGTH . ' caracteres'
        ];
    }
} 