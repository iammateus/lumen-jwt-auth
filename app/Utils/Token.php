<?php

namespace App\Utils;

use App\User;
use Firebase\JWT\JWT;

class Token {

    public static function create(User $user): string 
    {
        $privateKey = file_get_contents("/var/www/html/private.key");

        $payload = array(
            "iss" => "intercambiopravaler.com.br",
            "aud" => "intercambiopravaler.com.br",
            "iat" => time(),
            "exp" => time() + 60 * 60 * 24 * 365 * 1000,
            "user_id" => $user->id
        );
        
        $jwt = JWT::encode($payload, $privateKey, 'RS512');

        return $jwt;
    }

    public static function decode(string $token)
    {
        $publicKey = file_get_contents("/var/www/html/public.key");

        $decoded = JWT::decode($token, $publicKey, array('RS512'));

        return $decoded;
    }
}