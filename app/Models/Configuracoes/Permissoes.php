<?php

namespace App\Models\Configuracoes;

use Illuminate\Database\Eloquent\Model;

class Permissoes extends Model
{
  /**
   * Classe para a tabela de permissões do sistema
   * Criar, Visualizar, Editar, Excluir...
   */
  protected $table = 'tb_bas_permissoes';
  protected $primaryKey = 'id';
  public $timestamps = false;

  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = [
    'des_permissao',
    'flg_ativo',
  ];

  /** Seta a descrição da permissão */
  public function setPermissao($des_permissao)
  {
    $this->des_permissao = $des_permissao;
    $this->setId();
  }

  /** Seta o ID */
  public function setId()
  {
    $this->id = $this->where('des_permissao', $this->des_permissao)->firstOrFail()->id;
  }

  /** Retorna o ID da permissão setada */
  public function getId()
  {
    return $this->id;
  }

  /** Relations **/
  public function permissoes()
  {
    return $this->belongsToMany(Permissoes::class, RelFuncionalidadePerfil::class, 'id_permissao', 'id_permissao');
  }
}
