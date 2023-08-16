<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Bar;
use App\Providers\FooBarServiceProvider;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\ServiceProvider;
use Tests\TestCase;

class FooBarServiceProviderTest extends TestCase
{
       public function testServiceProvider()
    {
        
        $foo1 = $this->app->make(Foo::class);
        $foo2 = $this->app->make(Foo::class);

        self::assertSame($foo1,$foo2);

        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($bar1,$bar2);

        self::assertSame($foo1, $bar1->foo);
        self::assertSame($foo2, $bar2->foo);

    }
    

    public function testPropertySingletons()
    {
        //Membuat instance HelloService
        $helloService1 = $this->app->make(HelloService::class);
        $helloService2 = $this->app->make(HelloService::class);
         // Membuat instance HelloService lagi, tetapi ini akan mengembalikan instance yang sama seperti $helloService1
        // Memeriksa apakah $helloService1 dan $helloService2 adalah instance yang sama (singleton)
        self::assertSame($helloService1,$helloService2);
        
        self::assertEquals('Halo Grace',$helloService1->hello('Grace'));
    }

    public function testEmpty()
    {
        self::assertTrue(true);
    }
}
