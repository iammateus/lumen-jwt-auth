<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function buildFailedValidationResponse(Request $request, array $errors) {
        return response()->json(["message" => array_values($errors)[0][0] ], Response::HTTP_BAD_REQUEST);
    }
}
