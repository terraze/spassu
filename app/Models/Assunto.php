<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Assunto extends Model
{
    /**
     * Define o nome da tabela associada ao modelo     
     * @var string
     */
    protected $table = 'Assunto';

    /**
     * Define o nome da chave primária da tabela
     * @var string
     */
    protected $primaryKey = 'CodAs';

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
        'Descricao',        
    ];

    /**
     * Define a relação com o Assunto (N:N - um assunto pode ter vários livros)
     * @return BelongsToMany
    */
    public function livros(): BelongsToMany
    {
        return $this->belongsToMany(Livro::class, 'Livro_Assunto', 'Assunto_codAs', 'Livro_CodI')
                    ->using(Livro_Assunto::class);
    }
}
