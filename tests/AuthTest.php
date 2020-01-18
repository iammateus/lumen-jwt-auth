<?php

use Faker\Factory as Faker;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Utils\JWT;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testAuth()
    {
        $payload = [
            "iss" => "example.org",
            "aud" => "example.com",
            "iat" => 1356999524,
            "nbf" => 1357000000
        ];

        $token = JWT::encode($payload);

        $headers = [
            "Authorization" => 'Bearer '. $token
        ];

        $this->post("api/auth/test", [], $headers);
        $this->assertResponseOk();
    }

    public function testAuthWithoutSendingToken()
    {
        $this->post("api/auth/test");
        $this->assertResponseStatus(401);
        $this->seeJson(["error" => "Bearer token is missing."]);
    }

    public function testAuthWithoutSendingValidToken()
    {
        $faker = Faker::create();

        $headers = [
            "Authorization" => "Bearer " . $faker->text()
        ];

        $this->post("api/auth/test", [], $headers);

        $this->assertResponseStatus(401);
        $this->seeJson(["error" => "Bearer token is invalid."]);
    }

}
