<?php

namespace App\Http\Controllers;

use App\User;
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
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(["message" => "Logged successfully"], Response::HTTP_OK);
    }

}
