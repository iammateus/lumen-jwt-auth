<?php

namespace App\Http\Controllers;

use App\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Return a auth token.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where("email", $request->get("email"))->first();

        if(is_null($user)){
            return response()->json(["message" => "Email or password incorrect"], Response::HTTP_UNAUTHORIZED);
        }

        $passwordIsValid = Hash::check($request->get("password"), $user->password);

        if (!$passwordIsValid) {
            return response()->json(["message" => "Email or password incorrect"], Response::HTTP_UNAUTHORIZED);
        }

        return $this->responseWithToken($user);
    }

    public function responseWithToken(User $user)
    {

        $privateKey = file_get_contents("/var/www/html/private.key");

        $publicKey = file_get_contents("/var/www/html/public.key");

        $payload = array(
            "iss" => "intercambiopravaler.com.br",
            "aud" => "intercambiopravaler.com.br",
            "iat" => time(),
            "exp" => time() + 60 * 60 * 24 * 365 * 1000,
        );
        
        $jwt = JWT::encode($payload, $privateKey, 'RS512');

        $decoded = JWT::decode($jwt, $publicKey, array('RS512'));
        
        return response()->json([ "data" => [ "token" => print_r($jwt, true) ] ]);

    }

}
