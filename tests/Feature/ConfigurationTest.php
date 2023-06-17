<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ConfigurationTest extends TestCase
{
    public function testConfig()
    {
        $firstName = config('contoh.author.first');
        $lastName = config('contoh.author.last');
        $email = config('contoh.email');
        $web = config('contoh.web');

        self::assertEquals('Grace', $firstName);
        self::assertEquals('Amianie', $lastName);
        self::assertEquals('echo.gresce10@gmail.com',$email);
        self::assertEquals('https://www.programmerzamannow.com',$web);
    }
}
