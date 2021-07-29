<?php

namespace App\Http\Controllers\Cliente\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cadastros\Clientes;
use App\Models\Configuracoes\CadUsuario;
use App\Rules\ReCAPTCHAv3;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:cliente');
    }

    public function getPassword($token) {
        return view('Cliente.auth.passwords.resetPassword', ['token' => $token]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'des_login' => 'required|exists:tb_cad_clientes',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
            'password_confirmation' => 'required',
            'grecaptcha' => ['required', new ReCAPTCHAv3],
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where(['login' => $request->des_login, 'token' => $request->token])
                            ->first();

        if(!$updatePassword)
            return back()->withInput()->with('error', trans('messages.invalidToken'));

            Clientes::where('des_login', $request->des_login)
                        ->update(['password' => Hash::make($request->password_confirmation)]);

            DB::table('password_resets')->where(['login'=> $request->des_login])->delete();

            return redirect(route('clienteLogin'))->with('success', trans('messages.successPasswordReseted'));
    }
}
