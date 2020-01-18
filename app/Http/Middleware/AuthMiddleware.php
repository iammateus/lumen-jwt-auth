<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Utils\JWT;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $bearerToken = $request->bearerToken();
        
        if( is_null( $bearerToken ) ){
            return response()->json(["error" => "Bearer token is missing."], Response::HTTP_UNAUTHORIZED);
        }

        try
        {
            $jwt = JWT::decode($bearerToken);
        }catch(Exception $error)
        {
            return response()->json(["error" => "Bearer token is invalid."], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);

    }

}
