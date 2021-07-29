<?php

namespace App\Http\Controllers\Cliente\API;

use App\Http\Controllers\Controller;

use App\Http\Requests\API\AuthRequest;
use App\Transformers\API\ClienteTransformer;
use Carbon\Carbon;
use Flugg\Responder\Http\MakesResponses;

class AuthController extends Controller
{
    /** Trait para efetuar as respostas da API utilizando Laravel Responder **/
    use MakesResponses;
    
    /**
     * Login do Cliente via Login e Senha
     *
     * @return Flugg\Responder\Responder;
     */
    public function login(AuthRequest $request) {

        $credentials = $request->only(['des_login', 'password']);

        if (!$token = auth('api')->attempt($credentials))
            return $this->error(trans('errors.dados_invalidos'), trans('errors.usuario_ou_senha_invalidos'))->respond(422);

        return $this->respondWithToken($token);
    }

    /**
     * Retorna o cliente autênticado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return $this->success(auth('api')->user(), new ClienteTransformer());
    }

    /**
     * Logout do cliente
     * 
     * @return Flugg\Responder\Responder;
    */
    public function logout() {
        auth('api')->logout();
        return $this->success([ trans('auth.success_logout')] )->respond();
    }

    /**
     * Atualiza o token
    */
    public function refresh() {
        return $this->success([
            'token' => auth('api')->refresh()
        ])->respond();
    }

    /**
     * Responde passando o token e as informações de expiração e tipo
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        /**
         * Token JWT expira em 3600 segundos (1 hora)
         * Adicionamos os segundos a data atual para exibir a hora em que o token expirará
        */
        $token_expires_in = Carbon::now()->addSeconds(auth('api')->factory()->getTTL() * 60);
        return $this->success(
        [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in_seconds' => auth('api')->factory()->getTTL() * 60,
            'expires_in_date' => Carbon::parse($token_expires_in)->format('d/m/Y H:i:s')
        ])->respond();
    }
}