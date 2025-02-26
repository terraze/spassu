<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Livro extends Model
{
     /**
     * Define o nome da tabela associada ao modelo     
     * @var string
     */
    protected $table = 'Livro';

    /**
     * Define o nome da chave primária da tabela
     * @var string
     */
    protected $primaryKey = 'CodI';

     /**
     * Define o tipo da chave primária
     * @var string
     */
    public $keyType = 'integer';

    /**
     * Define o autoincremento da chave primária
     * @var bool
     */
    public $autoincrement = true;

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
        'Titulo',
        'Editora',
        'Edicao',
        'AnoPublicacao',        
    ];
}
