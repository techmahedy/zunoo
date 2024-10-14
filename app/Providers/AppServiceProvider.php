<?php

namespace App\Providers;

use App\TestClass;
use App\TestInterface;
use Mii\Container;

class AppServiceProvider extends Container
{
  /**
   * Register any application services.
   *
   * This method is used to bind services into the container. 
   * It is typically used to register service providers or other 
   * application-specific services that are needed throughout the app.
   *
   * @return void
   */
  public function register(): void
  {
    $this->bind(TestInterface::class, fn() => new TestClass());
  }
}
