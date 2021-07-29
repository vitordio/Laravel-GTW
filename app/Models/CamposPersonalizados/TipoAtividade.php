<?php

namespace App\Models\CamposPersonalizados;

use Illuminate\Database\Eloquent\Model;

class TipoAtividade extends Model
{
    protected $table = 'tb_cad_tipo_atividade';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Tipo Atividade';
   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'des_atividade',
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
    public function clientes()
    {
        return $this->belongsTo(Clientes::class, 'id', 'id');
    }

}
