<?php

namespace App\Models\Configuracoes;

use Illuminate\Database\Eloquent\Model;

class Funcionalidade extends Model
{
    protected $table = 'tb_bas_funcionalidade';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Funcionalidades';
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_menu',
        'des_link',
        'des_funcionalidade',
        'flg_ativo',
    ];

    /** Verifica se o menu está ativo **/
    public function isAtivo()
    {
        return $this->getOriginal('flg_ativo') == 'S';
    }

    /** Mutators **/
    public function getFlgAtivoAttribute($flg_ativo)
    {
        return $flg_ativo == 'S' ? 'Sim' : 'Não';
    }

    public function getNomFuncionalidade()
    {
      return $this->nom_funcionalidade;
    }

    /** Relations **/
    public function menu()
    {
        return $this->hasOne(Menu::class, 'id', 'id_menu');
    }

    public function permissoesFuncionalidade()
    {
        return $this->belongsToMany(Funcionalidade::class, RelFuncionalidadePerfil::class, 'id_funcionalidade', 'id_funcionalidade');
    }
}
