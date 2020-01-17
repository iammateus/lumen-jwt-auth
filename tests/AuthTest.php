<?php

use Faker\Factory as Faker;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testAuth()
    {
        $this->post("api/auth/test",[],["Authorization" => "Bearer "]);
        $this->assertResponseOk();
    }

    public function testAuthWithoutSendingAValidToken()
    {
        $this->post("api/auth/test");
        $this->assertResponseStatus(401);
    }


}
