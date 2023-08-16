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
    public function testCreateDependency() //melakukan dependencyinjection secara otomatis
    {
        $foo1 = $this->app->make(Foo::class); //ini seakan akan membuat foo seperti ini $foo = new Foo();
        $foo2 = $this->app->make(Foo::class); //new foo()
       
        self::assertEquals("Foo",$foo1->foo());  //assert untuk melakukan apa foo ini benar ada atau gak ada
        self::assertEquals("Foo",$foo2->foo());
       
        self::assertNotSame($foo1,$foo2);  //asssertNotSame, bahwa si objek foo dengan foo2 itu berbeda / tidak sama
       
    }

    public function testBind()
    {
        // $person = $this->app->make(Person::class); //new person() // error bindingresolutionexception,jadi tidak ada dependency yang bisa digunakan untuk memasukkan data ke dalam constructor ini 
        // self::assertNotNull($person);

        //menggunakan method bind
        $this->app->bind(Person::class, function ($app)
        {
            return new Person('Grace','Amianie');
        });

        //ini adalah 2 objek yang berbeda
        $person1 = $this->app->make(Person::class);//seakan akan manggil function closure() //new person ("Grace","Amianie");
        $person2 = $this->app->make(Person::class);//closure() //new person ("Grace","Amianie");

        self::assertEquals("Grace",$person1->firstName); 
        self::assertEquals("Grace",$person2->firstName); 
        self::assertNotSame($person1,$person2);
    }

    public function testSingleton()
    {

        $this->app->singleton(Person::class, function ($app)
        {
            return new Person('Grace','Amianie'); //new personnya hanya dibuat sekali saja
        });

        //ini adalah 2 objek yang sama 
        $person1 = $this->app->make(Person::class);//new person ('Grace','Amianie'); if no exists
        $person2 = $this->app->make(Person::class);//return existing
        $person3 = $this->app->make(Person::class);//return existing
        $person4 = $this->app->make(Person::class);//return existing
        //singleton, itu return existing jadi tidak membuat new person baru tapi mengembalikan yang sudah ada 
        self::assertEquals("Grace",$person1->firstName);
        self::assertEquals("Grace",$person2->firstName);
        self::assertSame($person1,$person2);
    }

    public function testInstance()
    {
        //jadi seperti ini, bila ingin memasukkan dependency objek yang sudah ada
        $person = new Person("Grace","Amianie"); //instansiasi object
        $this->app->instance(Person::class,$person);
        //mirip dengan singleton cuma bedanya kalau intance langsung kita masukkan $person nya disini / objek yang sudah ada

        $person1 = $this->app->make(Person::class); //mengembalikan objek $person
        $person2 = $this->app->make(Person::class);//mengembalikan objek $person
        $person3 = $this->app->make(Person::class);//mengembalikan objek $person
        $person4 = $this->app->make(Person::class);//mengembalikan objek $person

        self::assertEquals("Grace",$person1->firstName);
        self::assertEquals("Grace",$person2->firstName);
        // self::assertSame($person,$person1);
        self::assertSame($person1,$person2);
    }

    public function testDependencyInjection()
    {
        //bisa buat dependency otomatis dengan singleton jadi tak perlu new lagi
        $this->app->singleton(Foo::class, function ($app) //$app adalah parameter nya, dan service containernya si laravel
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
        
        //$this->app->singleton(HelloService::class, HelloServiceIndonesia::class); //cara pertama
        $this->app->singleton(HelloService::class, function($app){ //cara kedua
            return new HelloServiceIndonesia();
        });

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals('Halo Grace', $helloService->hello('Grace'));
    }
}
