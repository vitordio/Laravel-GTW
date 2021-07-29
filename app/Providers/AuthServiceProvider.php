<?php

namespace App\Providers;

use App\Models\Configuracoes\PerfilAcesso;
use App\User;
use Illuminate\Contracts\Auth\Access\Gate as AccessGate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(AccessGate $gate, PerfilAcesso $perfis)
    {
        $this->registerPolicies();

        foreach ($perfis->all() as $key => $perfil) {
            $gate->define($perfil->des_perfil, function(User $usuario) use ($perfil) {
                return $usuario->id_perfil_acesso === $perfil->id;
            });
        }
    }
}
