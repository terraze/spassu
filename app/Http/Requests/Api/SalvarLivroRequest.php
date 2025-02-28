<?php

namespace App\Http\Requests\Api;

use App\Models\Livro;

class SalvarLivroRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'Titulo' => 'required|string|max:' . Livro::MAX_TITULO_LENGTH,
            'Editora' => 'required|string|max:' . Livro::MAX_EDITORA_LENGTH,
            'Edicao' => 'required|integer|min:' . Livro::MIN_EDICAO,
            'AnoPublicacao' => 'required|integer|min:' . Livro::MIN_ANO_PUBLICACAO . '|max:' . Livro::getMaxAnoPublicacao(),
            'Preco' => 'required|numeric|min:' . Livro::MIN_PRECO,
            'Autores' => 'array',
            'Autores.*' => 'required|exists:Autor,CodAu',
            'Assuntos' => 'array',
            'Assuntos.*' => 'required|exists:Assunto,CodAs'
        ];
    }

    public function messages(): array
    {
        return [
            'Titulo.required' => 'O título é obrigatório',
            'Titulo.max' => 'O título não pode ter mais que ' . Livro::MAX_TITULO_LENGTH . ' caracteres',
            'Editora.required' => 'A editora é obrigatória',
            'Editora.max' => 'A editora não pode ter mais que ' . Livro::MAX_EDITORA_LENGTH . ' caracteres',
            'Edicao.required' => 'A edição é obrigatória',
            'Edicao.min' => 'A edição deve ser maior que zero',
            'AnoPublicacao.required' => 'O ano de publicação é obrigatório',
            'AnoPublicacao.min' => 'O ano de publicação deve ser entre ' . Livro::MIN_ANO_PUBLICACAO . ' e ' . Livro::getMaxAnoPublicacao(),
            'AnoPublicacao.max' => 'O ano de publicação não pode ser maior que o ano atual',
            'Preco.required' => 'O preço é obrigatório',
            'Preco.min' => 'O preço deve ser maior ou igual a ' . Livro::MIN_PRECO,
            'Autores.*.exists' => 'Um dos autores selecionados não existe',
            'Assuntos.*.exists' => 'Um dos assuntos selecionados não existe'
        ];
    }
} 