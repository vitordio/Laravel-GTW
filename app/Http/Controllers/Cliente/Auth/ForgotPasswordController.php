<?php

namespace App\Http\Controllers\Cliente\Auth;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
use App\Models\Cadastros\Clientes;
use App\Rules\ReCAPTCHAv3;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:cliente');
    }

    public function getEmail()
    {
        return view('Cliente.auth.passwords.forgotPassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'des_login' => 'required|exists:tb_cad_clientes',
            'grecaptcha' => ['required', new ReCAPTCHAv3],
        ]);

        $token = Biblioteca::v4();
        DB::table('password_resets')->insert(
            ['login' => $request->des_login, 'token' => $token, 'created_at' => Carbon::now()]
        );

        /** Pegamos os dados do cliente para enviar o e-mail */
        $cliente = Clientes::where('des_login', $request->des_login)->first();

        /** Envio do e-mail via Send Grid | Enviamos um parâmetro cliente, para alteração na rota */
        (new ForgotPasswordMail($cliente->des_email, $token, false))->build();

        return back()->with('success', trans('messages.mailResetPasswordSend'));
    }
}
