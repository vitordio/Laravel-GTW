<?php

namespace App\Providers\Configuracoes;

use App\Components\Biblioteca;

use App\Models\Configuracoes\CadUsuario;
use App\Models\Configuracoes\Log;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Hash;

class UsuarioProvider extends ServiceProvider
{    
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(CadUsuario $usuario, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarUsuários', function(User $usuarioLogado) use ($usuario, $perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuarioLogado->perfilAcesso, $usuario);
            }
        });

        $gate->define('CriarUsuario', function(User $usuarioLogado) use ($usuario, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_CRIAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuarioLogado->perfilAcesso, $usuario, $permissoes);
            }
        });

        $gate->define('VisualizarUsuario', function(User $usuarioLogado) use ($usuario, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuarioLogado->perfilAcesso, $usuario, $permissoes);
            }
        });

        $gate->define('EditarUsuario', function(User $usuarioLogado) use ($usuario, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EDITAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuarioLogado->perfilAcesso, $usuario, $permissoes);
            }
        });

        $gate->define('ExcluirUsuario', function(User $usuarioLogado) use ($usuario, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EXCLUIR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuarioLogado->perfilAcesso, $usuario, $permissoes);
            }
        });

        $usuario::creating(function($model) {
            if($model->flg_ativo == 'on' || $model->flg_ativo == 'Sim')
            {
                $model->flg_ativo = 'S';
            } else {
                $model->flg_ativo = 'N';
            }

            $model->password = Hash::make($model->password);
            $model->created_at = date('Y-m-d H:i:s');

            $model->email_verified_at = now();
            $model->remember_token = Biblioteca::v4();

            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a criação do usuário $model->des_nome no sistema."
            ]);

            $log->save();

        });

        $usuario::updating(function($model) {
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
                " realizou a edição do usuário de ID $model->id no sistema."
            ]);

            $log->save();
        });

        $usuario::deleting(function($model) {
            $model->flg_ativo = 'N';

            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a exclusão do usuário de ID $model->id no sistema."
            ]);

            $log->save();
        });
    }
}
