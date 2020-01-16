<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class HealthcheckTest extends TestCase
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
