<?php

namespace Utils;

use Firebase\JWT\JWT as JsonWebToken;

class JWT{

    public static function encode(array $payload): ?string
    {
        $bearerToken = JsonWebToken::encode($payload, self::getKey("PRIVATE"), 'RS512');
        return $bearerToken;
    }

    public static function decode(string $token): ?object
    {
        $bearerToken = JsonWebToken::decode($token, self::getKey(), [ 'RS512' ]);
        return $bearerToken;
    }

    public static function getKey(string $key = "PUBLIC"): ?string 
    {
        $key = env( 'JWT_' . $key . '_KEY' );
        return file_get_contents( base_path() . '/' . $key );
    }

}