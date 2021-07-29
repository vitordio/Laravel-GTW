<?php

namespace App\Providers\Cadastros;

use App\Components\Biblioteca;
use App\Mail\Admin\CadastroClienteMail;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\Models\Cadastros\Clientes;
use App\Models\Configuracoes\Log;
use App\User;

use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class ClientesProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Clientes $clientes, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarClientes', function(User $usuario) use ($clientes, $perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuario->perfilAcesso, $clientes);
            }
        });

        $gate->define('CriarClientes', function(User $usuario) use ($clientes, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_CRIAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $clientes, $permissoes);
            }
        });

        $gate->define('VisualizarClientes', function(User $usuario) use ($clientes, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $clientes, $permissoes);
            }
        });

        $gate->define('EditarClientes', function(User $usuario) use ($clientes, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EDITAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $clientes, $permissoes);
            }
        });

        $gate->define('ExcluirClientes', function(User $usuario) use ($clientes, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EXCLUIR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $clientes, $permissoes);
            }
        });

        $gate->define('GerarRelatorioClientes', function(User $usuario) use ($clientes, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_GERAR_RELATORIO);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $clientes, $permissoes);
            }
        });

        $clientes::creating(function($model) {
            if($model->flg_ativo == 'on' || $model->flg_ativo == 'Sim')
            {
                $model->flg_ativo = 'S';
            } else {
                $model->flg_ativo = 'N';
            }

            /** Guarda a senha para envio no e-mail */
            $passwordNoHash = $model->password;
            $model->password = Hash::make($model->password);
            $model->remember_token = Biblioteca::v4();

            $model->created_at = date('Y-m-d H:i:s');
            
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a criação do cliente $model->des_nome no sistema."
            ]);

            /** Envia o e-mail com as boas vindas e os dados de acesso **/
            (new CadastroClienteMail($model, $passwordNoHash))->build();

            $log->save();
        });

        $clientes::updating(function($model) {
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
                " realizou a edição do cliente de ID $model->id no sistema."
            ]);

            $log->save();
        });

        $clientes::deleting(function($model) {
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a exclusão do cliente de ID $model->id no sistema."
            ]);

            $log->save();
        });
    }
}
