<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function test (Request $request): JsonResponse
    {
        return response()->json( ["message" => "AUTHENTICATED"] , Response::HTTP_OK );
    }
}
