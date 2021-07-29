<?php

namespace App\Listeners;

use App\Models\Configuracoes\Log;
use Illuminate\Auth\Events\PasswordReset as ResetPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;

class PasswordReset
{
    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\PasswordReset  $event
     * @return void
     */
    public function handle(ResetPassword $event)
    {
        // Faz a inserção do novo log
        $log = new Log([
            'des_acao' => "Usuário " . $event->user->des_nome .
            " resetou a senha."
        ]);

        $log->save();

    }
}
