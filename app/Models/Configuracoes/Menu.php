<?php

namespace App\Models\Configuracoes;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'tb_bas_menu';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Menus';

    const DASHBOARD_MENU = 'Dashboard';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'des_menu',
        'des_icon',
        'flg_ativo',
    ];

    /** Mutators **/
    public function getFlgAtivoAttribute($flg_ativo)
    {
        return $flg_ativo == 'S' ? 'Sim' : 'Não';
    }

    public function getNomFuncionalidade()
    {
      return $this->nom_funcionalidade;
    }

    public function isAtivo()
    {
        return $this->getOriginal('flg_ativo') == 'S';
    }

    /** Relations **/
    public function submenu()
    {
        return $this->belongsTo(Funcionalidade::class, 'id', 'id_menu')->orderBy('des_funcionalidade');
    }
}
