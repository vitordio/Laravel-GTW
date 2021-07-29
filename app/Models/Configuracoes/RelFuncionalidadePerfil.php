<?php

namespace App\Models\Configuracoes;

use Illuminate\Database\Eloquent\Model;

class RelFuncionalidadePerfil extends Model
{
    /**
     * Tabela de relacionamento entre
     * - Funcionalidade
     * - Perfil de Acesso
     * - Permissões
     */
    protected $table = 'tb_rel_funcionalidade_perfil';
    protected $primaryKey = 'id';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'id_funcionalidade', 
      'id_perfil_acesso',
      'id_permissao',
    ];

    /** Relations **/
    public function funcionalidade()
    {
      return $this->hasOne(Funcionalidade::class, 'id', 'id_funcionalidade');
    }

    public function perfilAcesso()
    {
      return $this->hasOne(PerfilAcesso::class, 'id', 'id_perfil_acesso');
    }

    public function permissao()
    {
      return $this->hasOne(Permissoes::class, 'id', 'id_permissao');
    }

    /* Verificamos no form se existe a permissão para o perfil */
    public static function hasPermissaoFuncionalidade(PerfilAcesso $perfil, Permissoes $permissao, Funcionalidade $funcionalidade)
    {
      return (bool) RelFuncionalidadePerfil::where('id_perfil_acesso', $perfil->id)
      ->where('id_funcionalidade', $funcionalidade->id)
      ->where('id_permissao', $permissao->id)
      ->first();
    }
}
