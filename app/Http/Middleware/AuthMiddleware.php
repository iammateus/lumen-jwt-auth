<?php

namespace App\Http\Middleware;

use App\Utils\Token;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try{
           
            $token = $request->bearerToken();

            if(is_null($token)){
                return response()->json(["message" => "Unauthorized"], Response::HTTP_UNAUTHORIZED);
            }

            $jwt = Token::decode($token);

            $request->request->set("user_id", $jwt->user_id);

        }catch(Exception $error){

            return response()->json(["message" => "Unauthorized"], Response::HTTP_UNAUTHORIZED);
            
        }
        

        return $next($request);
    }
}
