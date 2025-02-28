<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseRequest;
use App\Models\Assunto;

class SalvarAssuntoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'Descricao' => 'required|string|max:' . Assunto::MAX_DESCRICAO_LENGTH
        ];
    }

    public function messages(): array
    {
        return [
            'Descricao.required' => 'A descrição é obrigatória',
            'Descricao.max' => 'A descrição não pode ter mais que ' . Assunto::MAX_DESCRICAO_LENGTH . ' caracteres'
        ];
    }
} 