<?php

namespace App\Providers;

use Zuno\Providers\ServiceProvider;

/**
 * AppServiceProvider is a custom service provider for the application.
 *
 * This provider is intended for registering and bootstrapping application-specific
 * services, bindings, or other setup logic. It is a place where developers can
 * add custom functionality that is specific to their application.
 *
 * The `register` method is used to bind services into the service container,
 * while the `boot` method is used to perform any additional setup after all
 * service providers have been registered.
 */
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
