<?php

namespace App\Http\Requests\Api;

use App\Http\Requests\Api\BaseRequest;
use App\Models\Assunto;

class SalvarAssuntoRequest extends BaseRequest
{
    /**
     * Regras de validação para a requisição
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Descricao' => 'required|string|max:' . Assunto::MAX_DESCRICAO_LENGTH
        ];
    }

    /**
     * Mensagens de erro para as regras de validação
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Descricao.required' => 'A descrição é obrigatória',
            'Descricao.max' => 'A descrição não pode ter mais que ' . Assunto::MAX_DESCRICAO_LENGTH . ' caracteres'
        ];
    }
} 