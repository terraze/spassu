<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    protected $primaryKey = 'CodL';

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

    /**
     * Define a relação com o Assunto (N:N - um livro pode ter vários assuntos)
     * @return BelongsToMany
     */
    public function assuntos(): BelongsToMany
    {
        return $this->belongsToMany(Assunto::class, 'Livro_Assunto', 'Livro_CodL', 'Assunto_codAs')
                    ->using(Livro_Assunto::class);
    }

    

    /**
     * Define a relação com o Autor (N:N - um livro pode ter vários autores)
     * @return BelongsToMany
     */
    public function autores(): BelongsToMany
    {
        return $this->belongsToMany(Autor::class, 'Livro_Autor', 'Livro_CodL', 'Autor_CodAu')
                    ->using(Livro_Autor::class);
    }
}
