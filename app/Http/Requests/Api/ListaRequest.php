<?php

namespace App\Http\Requests\Api;

abstract class ListaRequest extends BaseRequest
{
    /**
     * Regras da validação para a requisição
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ordenarCampo' => 'sometimes|string|in:' . implode(',', $this->getSortFields()),
            'ordenarDirecao' => 'sometimes|string|in:' . implode(',', $this->getSortDirections())
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
            'ordenarCampo.in' => 'O campo de ordenação deve ser um dos seguintes: ' . implode(', ', $this->getSortFields()),
            'ordenarDirecao.in' => 'A direção deve ser uma das seguintes: ' . implode(', ', $this->getSortDirections())
        ];
    }

    /**
     * Campos disponíveis para ordenação
     *
     * @return array
     */
    abstract protected function getSortFields(): array;

    /**
     * Direções disponíveis para ordenação
     *
     * @return array
     */
    protected function getSortDirections(): array
    {
        return ['asc', 'desc'];
    }
} 