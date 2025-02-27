<?php

namespace App\Http\Requests\Api;

class ListaAssuntoRequest extends BaseRequest
{
    private const SORT_FIELDS = ['CodAs', 'Descricao'];
    private const SORT_DIRECTIONS = ['asc', 'desc'];

    /**
     * Regras da validação para a requisição
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ordenarCampo' => 'sometimes|string|in:' . implode(',', self::SORT_FIELDS),
            'ordenarDirecao' => 'sometimes|string|in:' . implode(',', self::SORT_DIRECTIONS)
        ];
    }

    /**
     * Mensagens de erro para as regras de validação
     */
    public function messages(): array
    {
        return [
            'ordenarCampo.in' => 'O campo de ordenação deve ser um dos seguintes: ' . implode(', ', self::SORT_FIELDS),
            'ordenarDirecao.in' => 'A direção deve ser uma das seguintes: ' . implode(', ', self::SORT_DIRECTIONS)
        ];
    }
} 