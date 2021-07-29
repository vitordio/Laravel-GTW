<?php

namespace App\Providers\Configuracoes;

use App\Components\Biblioteca;

use App\Models\Configuracoes\Log;
use App\Models\Configuracoes\PerfilAcesso;
use App\Models\Configuracoes\Permissoes;
use App\User;

use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\ServiceProvider;

class LogProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Log $funcionalidade, AccessGate $gate, PerfilAcesso $perfis, Permissoes $permissoes)
    {
        /**
         * No caso do Log, para exibição do menu, verifica se tem
         * acesso a funcionalidade apenas de visualização
         */
        $gate->define('AcessarLog de Acessos', function(User $usuario) use ($funcionalidade, $perfis, $permissoes) {
            $permissoes->setPermissao(Biblioteca::ACTION_VISUALIZAR);
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasPermission($usuario->perfilAcesso, $funcionalidade, $permissoes);
            }
        });

        Log::creating(function($model) {
            $model->id_usuario = Auth::user()->id;
            $model->des_url = FacadesRequest::fullUrl();
            $model->num_ip = FacadesRequest::ip();
            $model->created_at = date('Y-m-d H:i:s');
        });
    }
}
