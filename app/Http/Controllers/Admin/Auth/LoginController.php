<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Components\Biblioteca;
use App\Http\Controllers\Controller;
use App\Models\Configuracoes\Log;
use App\Rules\ReCAPTCHAv3;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Exception;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'des_email';
    }

    /**
     * Função para o login no sistema
     */
    public function login(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
            'grecaptcha' => ['required', new ReCAPTCHAv3],
        ]);

        try {
            $usuario = User::where('des_email', $request->des_email)
            ->where('flg_ativo', Biblioteca::FLG_ATIVO)
            ->firstOrFail();
            
            // If the class is using the ThrottlesLogins trait, we can automatically throttle
            // the login attempts for this application. We'll key this by the username and
            // the IP address of the client making these requests into this application.
            if ($this->hasTooManyLoginAttempts($request)) 
            {
                $this->fireLockoutEvent($request);

                return $this->sendLockoutResponse($request);
            }

            if(isset($usuario))
            {
                if ($this->attemptLogin($request)) 
                {
                    return $this->sendLoginResponse($request);
                }
            }

            Session::flash('message', __('messages.falhaLogin'));
			Session::flash('alert-class', 'alert-danger'); 

        } catch (Exception $ex) {
            Session::flash('message', __('messages.falhaLogin'));
			Session::flash('alert-class', 'alert-danger');
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function showLoginForm()
    {
        return view('Admin.auth.login');
	}

    public function logout(Request $request)
    {
        // Faz a inserção do novo log
        $log = new Log([
            'des_acao' => "Usuário " . Auth::user()->des_nome .
            " fez o logout do sistema."
        ]);

        $log->save();

        Auth::logout();
        Session::flush();

        return response()->json([
            'urlLogin' => route('login')
        ]);
    }
}
