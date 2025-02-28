<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class BaseRequest extends FormRequest
{
    /**
     * Não requer login
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Tratamento de erro de validação
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Parâmetros inválidos',
            'errors' => $validator->errors(),            
        ], 400));
    }
} 