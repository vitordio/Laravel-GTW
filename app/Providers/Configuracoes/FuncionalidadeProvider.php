<?php

namespace App\Providers\Configuracoes;

use App\Components\Biblioteca;
use App\Models\Configuracoes\Funcionalidade;
use App\Models\Configuracoes\Log;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class FuncionalidadeProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Funcionalidade $funcionalidade, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarFuncionalidades', function(User $usuario) use ($funcionalidade, $perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuario->perfilAcesso, $funcionalidade);
            }
        });

        $gate->define('CriarFuncionalidade', function(User $usuario) use ($funcionalidade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_CRIAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $funcionalidade, $permissoes);
            }
        });

        $gate->define('VisualizarFuncionalidade', function(User $usuario) use ($funcionalidade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $funcionalidade, $permissoes);
            }
        });

        $gate->define('EditarFuncionalidade', function(User $usuario) use ($funcionalidade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EDITAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $funcionalidade, $permissoes);
            }
        });

        $gate->define('ExcluirFuncionalidade', function(User $usuario) use ($funcionalidade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EXCLUIR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $funcionalidade, $permissoes);
            }
        });

        $funcionalidade::creating(function($model) {
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
                " realizou a criação da funcionalidade " . $model->des_funcionalidade .
                " no sistema."
            ]);

            $log->save();
        });

        $funcionalidade::updating(function($model) {
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
                " realizou a edição da funcionalidade " . $model->des_funcionalidade .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });

        $funcionalidade::deleting(function($model) {
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a exclusão da funcionalidade " . $model->des_funcionalidade .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });
    }
}
