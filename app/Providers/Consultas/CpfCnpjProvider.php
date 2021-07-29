<?php

namespace App\Providers\Consultas;

use App\Models\Configuracoes\PerfilAcesso;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Support\ServiceProvider;

class CpfCnpjProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(AccessGate $gate, PerfilAcesso $perfis)
    {
        /**
         * Verifica se o usuário tem acesso à pelo menos uma ação das funcionalidades (Criar, Visualiar, Editar ou Excluir)
         * para exibição da tela e menu
         */
        $gate->define('AcessarCPF/CNPJ', function(User $usuario) use ($perfis) {
            foreach ($perfis->all() as $perfil) {
                return $perfil->hasAnyPermission($usuario->perfilAcesso, $this);
            }
        });
    }

    public function getNomFuncionalidade() {
        return 'CPF/CNPJ';
    }
}
