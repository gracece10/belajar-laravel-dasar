<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
// use Illuminate\Support\Env; //untuk opsi kedua
use Tests\TestCase;

class EnvironmentTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    /*public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }*/
    
    public function testGetEnv()
    {
        $youtube = env('YOUTUBE');

        self::assertEquals('Grace Oscarissa Amianie', $youtube);
    }

    public function testDefaultEnv()
    {
        $author = env('AUTHOR', 'Grace');
        //$author = Env::get('AUTHOR', 'Grace'); //Opsi kedua
        self::assertEquals('Grace', $author);
    }
}
