<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Flugg\Responder\Http\MakesResponses;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Tymon\JWTAuth\Exceptions\{TokenExpiredException, TokenInvalidException};

class ApiProtectedRoute extends BaseMiddleware
{
    use MakesResponses;
    
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $exception) {
            if ($exception instanceof TokenInvalidException) {
                $status = trans('errors.invalid_token');
            } else if ($exception instanceof TokenExpiredException) {
                $status = trans('errors.expired_token');
            } else {
                $status = trans('errors.not_found_token');
            }

            return $this->error('erro_autenticacao', $status)->respond(401);
        }

        return $next($request);
    }
}