<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;

class Autor extends Model
{
    public const MAX_NOME_LENGTH = 40;

    /**
     * Define o nome da tabela associada ao modelo     
     * @var string
     */
    protected $table = 'Autor';

    /**
     * Define o nome da chave primária da tabela
     * @var string
     */
    protected $primaryKey = 'CodAu';

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
        'Nome',        
    ];

    /**
     * Define a relação com o Autor (N:N - um autor pode ter vários livros)
     * @return BelongsToMany
    */
    public function livros(): BelongsToMany
    {
        return $this->belongsToMany(Livro::class, 'Livro_Autor', 'Autor_CodAu', 'Livro_CodL')
                    ->using(Livro_Autor::class);
    }

    /**
     * Verifica se o assunto está sendo usado em algum livro
     */
    public function estaEmUso()
    {
        return DB::table('Livro_Autor')
            ->where('CodAu', $this->CodAu)
            ->exists();
    }

    /**
     * Remove todas as associações deste assunto com livros
     */
    public function removerAssociacoesLivros()
    {
        return DB::table('Livro_Autor')
            ->where('CodAu', $this->CodAu)
            ->delete();
    }
}
