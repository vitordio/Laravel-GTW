<?php

namespace App\Models\Configuracoes;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class CadUsuario extends Model
{
  use Notifiable, SoftDeletes;

  protected $table = 'tb_cad_usuario';
  protected $primaryKey = 'id';
  public $timestamps = false;
  public $nom_funcionalidade = 'Usuários';

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'id_perfil_acesso',
    'des_nome',
    'des_email',
    'password',
    'flg_ativo'
  ];

  /**
   * Coluna deleted_at como um Mutator de data
   *
   * @var array
   */
  protected $dates = ['deleted_at'];

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
  public function perfilAcesso()
  {
    return $this->hasOne(PerfilAcesso::class, 'id', 'id_perfil_acesso');
  }
}
