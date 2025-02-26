<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    /**
     * Define o nome da chave primária da tabela
     * @var string
     */
    protected $primaryKey = 'CodAs';

    /**
     * Define o nome da tabela associada ao modelo     
     * @var string
     */
     protected $table = 'Assunto';

     /**
     * Não criar campos para created_at e updated_at
     *
     * @var bool
     */
    public $timestamps = false;

     /**
      * Define os campos que podem ser atribuídos em massa
      */
    protected $fillable = [
        'Descricao',        
    ];
}
