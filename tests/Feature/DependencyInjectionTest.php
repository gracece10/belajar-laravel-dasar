<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Bar;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DependencyInjectionTest extends TestCase
{
    
    public function testDependencyInjection()
    {
        //melakukan dependencyinjection secara manual
        $foo = new Foo();
        $bar = new Bar($foo);
        //function
        // $bar->setFoo($foo); 
        //atribut atau properti
        // $bar->foo = $foo; 
        self::assertEquals('Foo and Bar', $bar->bar());
    }
}
