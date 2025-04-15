<?php

namespace App\Providers;

use Zuno\Providers\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * This method is called when the service provider is registered.
   * It is used to bind services, factories, or other dependencies into
   * the service container. This is where you can define custom bindings
   * or register application-specific services.
   *
   * @return void
   */
  public function register(): void
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * This method is called after all service providers have been registered.
   * It is used to perform additional setup
   *
   * @return void
   */
  public function boot(): void
  {
    //
  }
}
