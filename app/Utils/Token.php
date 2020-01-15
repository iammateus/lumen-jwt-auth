<?php

namespace App\Utils;

use App\User;
use Firebase\JWT\JWT;

class Token {

    public static function createUserToken(User $user): string 
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

        // To decode use something like:
        //$decoded = JWT::decode($jwt, $publicKey, array('RS512'));

        return $jwt;
    }

}