<?php

namespace App\Providers\Configuracoes;

use App\Components\Biblioteca;

use App\Models\Configuracoes\Log;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\User;

use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class PerfilAcessoProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(PerfilAcesso $perfilAcesso, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarPerfis de Acesso', function(User $usuario) use ($perfilAcesso, $perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuario->perfilAcesso, $perfilAcesso);
            }
        });

        $gate->define('CriarPerfilAcesso', function(User $usuario) use ($perfilAcesso, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_CRIAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $perfilAcesso, $permissoes);
            }
        });

        $gate->define('VisualizarPerfilAcesso', function(User $usuario) use ($perfilAcesso, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $perfilAcesso, $permissoes);
            }
        });

        $gate->define('EditarPerfilAcesso', function(User $usuario) use ($perfilAcesso, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EDITAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $perfilAcesso, $permissoes);
            }
        });

        $gate->define('ExcluirPerfilAcesso', function(User $usuario) use ($perfilAcesso, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EXCLUIR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $perfilAcesso, $permissoes);
            }
        });

        $perfilAcesso::creating(function($model) {
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
                " realizou a criação do perfil de acesso " . $model->des_perfil .
                " no sistema."
            ]);

            $log->save();
        });

        $perfilAcesso::updating(function($model) {
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
                " realizou a edição do perfil de acesso " . $model->des_perfil .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });

        $perfilAcesso::deleting(function($model) {
            $model->flg_ativo = 'N';
            
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a exclusão do perfil de acesso " . $model->des_perfil .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });
    }
}
