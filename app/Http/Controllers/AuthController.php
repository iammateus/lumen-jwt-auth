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

        $key = '6w9z$C&F)J@NcRfUjXn2r5u7x!A%D*G-KaPdSgVkYp3s6v9y/B?E(H+MbQeThWmZq4t7w!z%C&F)J@NcRfUjXn2r5u8x/A?D(G-KaPdSgVkYp3s6v9y$B&E)H@MbQeThWmZq4t7w!z%C*F-JaNdRfUjXn2r5u8x/A?D(G+KbPeShVkYp3s6v9y$B&E)H@McQfTjWnZq4t7w!z%C*F-JaNdRgUkXp2s5u8x/A?D(G+KbPeShVmYq3t6w9y$B&E)H@McQfTjWnZr4u7x!A%C*F-JaNdRgUkXp2s5v8y/B?E(G+KbPeShVmYq3t6w9z$C&F)J@McQfTjWnZr4u7x!A%D*G-KaPdSgUkXp2s5v8y/B?E(H+MbQeThWmYq3t6w9z$C&F)J@NcRfUjXn2r4u7x!A%D*G-KaPdSgVkYp3s6v8y/B?E(H+MbQeThWmZq4t7w!z$C&F)J@NcRfUjXn2r5u8x/A?D*G-KaPdSgVkYp3s6v9y$B&E)H+MbQeThWmZq4';

        $payload = array(
            "iss" => "intercambiopravaler.com.br",
            "aud" => "example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000,
            "userId" => $user->id
        );
        
        $jwt = JWT::encode($payload, $key, 'HS512');

        // $decoded = JWT::decode($jwt, $key, array('HS512'));
        
        return response()->json([ "data" => [ "token" => print_r($jwt, true) ] ]);

    }

}
