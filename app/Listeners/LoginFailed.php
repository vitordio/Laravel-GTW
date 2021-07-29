<?php

namespace App\Listeners;

use App\Models\Configuracoes\Log;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;

class LoginFailed
{
    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        // Faz a inserção do novo log
        $log = new Log([
            'des_acao' => "Usuário " . $event->user->des_nome .
            " logou no sistema."
        ]);

        $log->save();

        Session::flash('login-success', 'Olá, ' . $event->user->des_nome . ' bem vindo de volta!');
    }
}
