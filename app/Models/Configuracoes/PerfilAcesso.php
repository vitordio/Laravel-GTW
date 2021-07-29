<?php

namespace App\Models\Configuracoes;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerfilAcesso extends Model
{
    use HasPermissionsTrait, SoftDeletes;
    
    protected $table = 'tb_cad_perfil_acesso';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $nom_funcionalidade = 'Perfis de Acesso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'des_perfil', 
        'des_descricao_perfil',
        'flg_ativo',
    ];

    /**
     * Coluna deleted_at como um Mutator de data
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /** Mutators **/
    public function getFlgAtivoAttribute($flg_ativo) {
        return $flg_ativo == 'S' ? 'Sim' : 'Não';
    }

    public function getNomFuncionalidade()
    {
      return $this->nom_funcionalidade;
    }

    /** Verifica se o perfil é de Admin para bloqueio dos campos **/
    public function isAdmin()
    {
        return $this->des_perfil == 'Administrador';
    }

    public function isAtivo()
    {
        return $this->getOriginal('flg_ativo') == 'S';
    }

    /** Relations **/
    public function usuarioPerfil()
    {
        return $this->belongsTo(CadUsuario::class, 'id', 'id_perfil_acesso');
    }

    public function permissoesPerfil()
    {
        return $this->belongsToMany(PerfilAcesso::class, RelFuncionalidadePerfil::class, 'id_perfil_acesso', 'id_perfil_acesso');
    }
}
