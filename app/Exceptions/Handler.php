<?php

namespace App\Exceptions;

use Exception;
use Flugg\Responder\Http\MakesResponses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;

class Handler extends ExceptionHandler
{
    use MakesResponses;

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Mensagem com os erros de validação e mensagem customizada
        if ($exception instanceof ValidationException)
            return $this->error('campos_obrigatorios', trans('errors.campos_obrigatorios'))->data(['errors' => $exception->validator->getMessageBag()])->respond(422);

        return parent::render($request, $exception);
    }

    /**
     * Se alguém tentar acessar as rotas do administrador sem fazer login, por padrão,
     * redireciona para o login do cliente, alteramos para redirecionar para a rota desejada
    */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return $this->error('nao_logado', trans('errors.nao_logado'))->respond(401);
        }

        $guard = Arr::get($exception->guards(), 0);
        switch ($guard) {
            case 'web':
                $login = 'admin/login';
                break;
            default:
                $login = 'login';
                break;
        }

        return redirect()->guest(url($login));
    }

}
