<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Mail\ForgotPasswordMail;
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
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getEmail()
    {
        return view('Admin.auth.passwords.forgotPassword');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'des_email' => 'required|email|exists:tb_cad_usuario',
            'grecaptcha' => ['required', new ReCAPTCHAv3],
        ]);

        $token = Biblioteca::v4();
        DB::table('password_resets')->insert(
            ['login' => $request->des_email, 'token' => $token, 'created_at' => Carbon::now()]
        );

        /** Envio do e-mail via Send Grid **/
        (new ForgotPasswordMail($request->des_email, $token, true))->build();

        return back()->with('success', trans('messages.mailResetPasswordSend'));
    }
}
