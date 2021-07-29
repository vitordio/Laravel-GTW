<?php
namespace App\Permissions;

use App\Models\Configuracoes\Funcionalidade;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\Models\Configuracoes\RelFuncionalidadePerfil;

trait HasPermissionsTrait {

    /**
     * Verifica se o usuário tem acesso a determinada ação na funcionalidade
     *
     * @param App\Models\Configuracoes\PerfilAcesso $perfil 
     * @param App\Models\Configuracoes\Funcionalidade $funcionalide
     * @param App\Models\Configuracoes\Permissoes $permissao
     * 
     * @return (bool)
     */
    public function hasPermission(PerfilAcesso $perfil, $funcionalidade, Permissoes $permissao) {
        return (bool) RelFuncionalidadePerfil::where('id_perfil_acesso', $perfil->id)
        ->where('id_funcionalidade', $this->getIdFuncionalidade($funcionalidade->getNomFuncionalidade()))
        ->where('id_permissao', $permissao->getId())
        ->count();
    }

    /**
     * Verifica se o usuário tem acesso à pelo menos uma ação na funcionalidade
     * @param App\Models\Configuracoes\PerfilAcesso $perfil 
     * @param App\Models\Configuracoes\Funcionalidade $funcionalide
     * 
     * @return (bool)
     */
    public function hasAnyPermission(PerfilAcesso $perfil, $funcionalidade) {
        return (bool) RelFuncionalidadePerfil::where('id_perfil_acesso', $perfil->id)
        ->where('id_funcionalidade', $this->getIdFuncionalidade($funcionalidade->getNomFuncionalidade()))
        ->count();
    } 

    /**
     * Retorna o ID da funcionalidade
    */
    protected function getIdFuncionalidade($nom_funcionalidade)
    {
        return Funcionalidade::where('des_funcionalidade', $nom_funcionalidade)->firstOrFail()->id;
    }

}