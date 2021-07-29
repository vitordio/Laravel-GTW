<?php

namespace App\Providers\CamposPersonalizados;

use App\Components\Biblioteca;

use App\Models\CamposPersonalizados\TipoAtividade;
use App\Models\Configuracoes\Log;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\User;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Auth;

class TipoAtividadeProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(TipoAtividade $tipoAtividade, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarTipo Atividade', function(User $usuario) use ($tipoAtividade, $perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuario->perfilAcesso, $tipoAtividade);
            }
        });

        $gate->define('CriarTipoAtividade', function(User $usuario) use ($tipoAtividade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_CRIAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $tipoAtividade, $permissoes);
            }
        });

        $gate->define('VisualizarTipoAtividade', function(User $usuario) use ($tipoAtividade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $tipoAtividade, $permissoes);
            }
        });

        $gate->define('EditarTipoAtividade', function(User $usuario) use ($tipoAtividade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EDITAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $tipoAtividade, $permissoes);
            }
        });

        $gate->define('ExcluirTipoAtividade', function(User $usuario) use ($tipoAtividade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_EXCLUIR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $tipoAtividade, $permissoes);
            }
        });

        $tipoAtividade::creating(function($model) {
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
                " realizou a criação do tipo de atividade " . $model->des_atividade .
                " no sistema."
            ]);

            $log->save();
        });

        $tipoAtividade::updating(function($model) {
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
                " realizou a edição do tipo de atividade " . $model->des_atividade .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });

        $tipoAtividade::deleting(function($model) {
            // Faz a inserção do novo log
            $log = new Log([
                'des_acao' => "Usuário " . Auth::user()->des_nome .
                " realizou a exclusão do tipo de atividade " . $model->des_atividade .
                " de ID $model->id no sistema."
            ]);

            $log->save();
        });
    }
}
