<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Livro_Assunto extends Pivot
{
    /**
     * Define o nome da tabela associada ao modelo     
     * @var string
     */
    protected $table = 'Livro_Assunto';
     /**
     * Não criar campos para created_at e updated_at
     *
     * @var bool
     */
    public $timestamps = false;    

    /**
     * Define os campos que podem ser atribuídos em massa
     */
    protected $fillable = ['Livro_CodI', 'Assunto_codAs'];
}
