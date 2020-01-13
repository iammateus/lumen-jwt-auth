<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        
        $this->validate($request, [
            "name" => "required|string",
            "email" => "required|email|unique:users",
            "password" => "required|confirmed"
        ]);

        try{

            $user = new User;

            $user->name = $request->input("name");
            $user->email = $request->input("email");
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);

            $user->save();
            
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        }catch(\Exception $e){

            return response()->json(
                ["message" => "User registration failed"]
                , Response::HTTP_CONFLICT
            );
        
        }
    }
}
