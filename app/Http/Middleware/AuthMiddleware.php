<?php

namespace App\Http\Middleware;

use Closure;
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
        if( is_null( $request->bearerToken() ) ){
            return response()->json(["message" => "UNAUTHORIZED"], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
