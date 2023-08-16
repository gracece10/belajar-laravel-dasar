<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App; //import App
use Tests\TestCase;

class AppEnvironmentTest extends TestCase
{

    public function testAppEnv()
    {
        // var_dump(App::environment()); 
        //untuk mengecek sedang di environment apa, hasilnya yang keluar adalah "testing" bisa dicek diphpunit
        if(App::environment('testing'))
        {
            //kode program kita
            self::assertTrue(true);
        }
        //atau 
        
        // if(App::environment('testing','prod','env'))
        // {
        //     self::assertTrue(true);
        // }
    }

}
