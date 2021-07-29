<?php

namespace App\Listeners;

use App\Models\Configuracoes\Log;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class LogoutSuccessful
{
    // public $guard;
    // public $user;

    // /**
    //  * Create the event listener.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->guard = Auth::guard();
    //     $this->user = Auth::user();
    // }
    
    /**
     * Handle the event.
     *
     * @param  Illuminate\Auth\Events\Logout  $event
     * @return void
     */
    public function handle(Logout $event)
    {
        Auth::logout();
        Session::flush();

        // Faz a inserção do novo log
        $log = new Log([
            'des_acao' => "Usuário " . $event->user->des_nome .
            " fez o logout do sistema."
        ]);

        $log->save();
    }
}
