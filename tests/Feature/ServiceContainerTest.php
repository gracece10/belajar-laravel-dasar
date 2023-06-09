<?php

namespace Tests\Feature;

use App\Data\Foo;
use App\Data\Bar;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testCreateDependency()
    {
        $foo = $this->app->make(Foo::class); //new foo()
        $foo2 = $this->app->make(Foo::class); //new foo()

        self::assertEquals("Foo",$foo->foo());
        self::assertEquals("Foo",$foo2->foo());
        self::assertNotSame($foo,$foo2);
    }

    public function testBind()
    {
        // $person = $this->app->make(Person::class); //new person()
        // self::assertNotNull($person);

        $this->app->bind(Person::class, function ($app)
        {
            return new Person('Grace','Amianie');
        });

        $person1 = $this->app->make(Person::class);
        $person2 = $this->app->make(Person::class);

        self::assertEquals("Grace",$person1->firstName); //closure() //new person ("Grace","Amianie");
        self::assertEquals("Grace",$person2->firstName); //closure() //new person ("Grace","Amianie");
        self::assertNotSame($person1,$person2);
    }

    public function testSingleton()
    {

        $this->app->singleton(Person::class, function ($app)
        {
            return new Person('Grace','Amianie');
        });

        $person1 = $this->app->make(Person::class);//new person ('Grace','Amianie'); if no exists
        $person2 = $this->app->make(Person::class);//return existing
        $person3 = $this->app->make(Person::class);//return existing
        $person4 = $this->app->make(Person::class);//return existing

        self::assertEquals("Grace",$person1->firstName);
        self::assertEquals("Grace",$person2->firstName);
        self::assertSame($person1,$person2);
    }

    public function testInstance()
    {

        $person = new Person("Grace","Amianie"); //instansiasi object
        $this->app->instance(Person::class,$person);

        $person1 = $this->app->make(Person::class); //$person
        $person2 = $this->app->make(Person::class);//$person
        $person3 = $this->app->make(Person::class);//$person
        $person4 = $this->app->make(Person::class);//$person

        self::assertEquals("Grace",$person1->firstName);
        self::assertEquals("Grace",$person2->firstName);
        // self::assertSame($person,$person1);
        self::assertSame($person1,$person2);
    }

    public function testDependencyInjection()
    {

        $this->app->singleton(Foo::class, function ($app)
        {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function ($app)
        {
            $foo = $app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);

        self::assertSame($foo, $bar1->foo);

        self::assertSame($bar1, $bar2);
    }

    public function testInterfaceToClass()
    {
        //$this->app->singleton(HelloService::class, HelloServiceIndonesia::class);
        $this->app->singleton(HelloService::class, function($app){
            return new HelloServiceIndonesia();
        });

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals('Halo Grace', $helloService->hello('Grace'));
    }
}
