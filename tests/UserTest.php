<?php

use Faker\Factory as Faker;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    
    public function testUserRegistration()
    {
        $faker = Faker::create();

        $password = $faker->password();

        $this->post('/api/user',
            [
                "name" => $faker->name(),
                "email" => $faker->email(),
                "password" => $password,
                "password_confirmation" => $password,
            ]
        );

        $this->assertResponseStatus(201);
        $this->seeJson(["message" => "CREATED"]);
        $this->seeJsonStructure([
            "user" => [
                "id",
                "name",
                "email",
                "created_at",
                "updated_at"
            ]
        ]);
    }

    public function testUserRegistrationWithoutSendingName()
    {
        $this->post('/api/user');

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The name field is required."]);
    }
    
    public function testUserRegistrationWithoutSendingNameOfTypeString()
    {
        $faker = Faker::create();

        $this->post('/api/user',
            [
                "name" => $faker->randomNumber()
            ]
        );

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The name must be a string."]);
    }

    public function testUserRegistrationWithoutSendingEmail()
    {
        $faker = Faker::create();

        $this->post('/api/user',
            [
                "name" => $faker->name()
            ]
        );

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The email field is required."]);
    }

    public function testUserRegistrationWithoutSendingEmailOfTypeEmail()
    {
        $faker = Faker::create();

        $this->post('/api/user',
            [
                "name" => $faker->name(),
                "email" => $faker->name()
            ]
        );

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The email must be a valid email address."]);
    }

    public function testUserRegistrationWithAUsedEmail()
    {
        $user = factory(App\User::class)->make();
        $user->save();

        $faker = Faker::create();

        $this->post('/api/user',
            [
                "name" => $faker->name(),
                "email" => $user->email
            ]
        );

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The email has already been taken."]);
    }

    public function testUserRegistrationWithoutSendingPassword()
    {
        $faker = Faker::create();

        $this->post('/api/user',
            [
                "name" => $faker->name(),
                "email" => $faker->email()
            ]
        );

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The password field is required."]);
    }
    
    public function testUserRegistrationWithoutSendingPasswordConfirmation()
    {
        $faker = Faker::create();

        $password = $faker->password();

        $this->post('/api/user',
            [
                "name" => $faker->name(),
                "email" => $faker->email(),
                "password" => $password,
            ]
        );

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The password confirmation does not match."]);
    }
    
    public function testUserRegistrationSendingWrongPasswordConfirmation()
    {
        $faker = Faker::create();

        $this->post('/api/user',
            [
                "name" => $faker->name(),
                "email" => $faker->email(),
                "password" => $faker->password(),
                "password_confirmation" => $faker->password()
            ]
        );

        $this->assertResponseStatus(400);
        $this->seeJson(["error" => "The password confirmation does not match."]);
    }

}
