<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class Healthcheck extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testStatusCode()
    {
        $this->get('/healthcheck');
        $this->assertResponseOk();
    }
}
