<?php

namespace App\Providers;

use App\Data\Foo; 
use App\Data\Bar;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia; 
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class FooBarServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        HelloService::class => HelloServiceIndonesia::class
     ]; 
    

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Mengganti binding HelloService sesuai konfigurasi
        // $this->app->singleton(HelloService::class, function ($app) {
        //     return $app->make(HelloServiceIndonesia::class);
        // });

        //echo "FooBarServiceProvider";
        $this->app->singleton(Foo::class, function ($app) {
            return new Foo();
        });
        $this->app->singleton(Bar::class, function ($app) {
            return new Bar($app->make(Foo::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    public function provides()
    {
        return [HelloService::class, Foo::class, Bar::class];
    }
}
