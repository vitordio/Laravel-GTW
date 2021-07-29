<?php

namespace App\Providers\Configuracoes;

use App\Components\Biblioteca;

use App\Models\Configuracoes\Menu;
use App\Models\Configuracoes\Log;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\User;

use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class MenuProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Menu $menu, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarMenus', function(User $usuario) use ($menu, $perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuario->perfilAcesso, $menu);
            }
        });

        $gate->define('CriarMenu', function(User $usuario) use ($menu, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_CRIAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $menu, $permissoes);
            }
        });

        $gate->define('VisualizarMenu', function(User $usuario) use ($menu, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $menu, $permissoes);
            }
        });

        $gate->define('EditarMenu', function(User $usuario) use ($menu, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EDITAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $menu, $permissoes);
            }
        });

        $gate->define('ExcluirMenu', function(User $usuario) use ($menu, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EXCLUIR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $menu, $permissoes);
            }
        });

        $menu::creating(function($model) {
            if($model->flg_ativo == 'on' || $model->flg_ativo == 'Sim')
            {
                $model->flg_ativo = 'S';
            } else {
                $model->flg_ativo = 'N';
            }

            $model->created_at = date('Y-m-d H:i:s');

            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a criação do menu " . $model->des_menu .
                " no sistema."
            ]);

            $log->save();
        });

        $menu::updating(function($model) {
            if($model->flg_ativo == 'on' || $model->flg_ativo == 'Sim')
            {
                $model->flg_ativo = 'S';
            } else {
                $model->flg_ativo = 'N';
            }

            $model->updated_at = date('Y-m-d H:i:s');

            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a edição do menu " . $model->des_menu .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });

        $menu::deleting(function($model) {
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a exclusão do do menu " . $model->des_menu .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });
    }
}
