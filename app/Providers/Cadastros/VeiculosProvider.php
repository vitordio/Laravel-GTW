<?php

namespace App\Providers\Cadastros;

use App\Components\Biblioteca;

use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\Models\Cadastros\Veiculos;
use App\User;

use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class VeiculosProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Veiculos $veiculos, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarVeículos', function(User $usuario) use ($veiculos, $perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuario->perfilAcesso, $veiculos);
            }
        });

        $gate->define('CriarVeiculos', function(User $usuario) use ($veiculos, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_CRIAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $veiculos, $permissoes);
            }
        });

        $gate->define('VisualizarVeiculos', function(User $usuario) use ($veiculos, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $veiculos, $permissoes);
            }
        });

        $gate->define('EditarVeiculos', function(User $usuario) use ($veiculos, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EDITAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $veiculos, $permissoes);
            }
        });

        $gate->define('ExcluirVeiculos', function(User $usuario) use ($veiculos, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EXCLUIR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $veiculos, $permissoes);
            }
        });
    }
}
