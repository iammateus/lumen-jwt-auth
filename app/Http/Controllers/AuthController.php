<?php

namespace App\Http\Controllers;

use App\User;
use App\Utils\Token;
use Firebase\JWT\JWT;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Authenticates user by email and password and returns a token
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
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

        return $this->respondWithToken(Token::createUserToken($user));
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    public function respondWithToken(string $token): JsonResponse
    {
        return response()->json([
            'access_token' => $token
        ]);
    }

}
