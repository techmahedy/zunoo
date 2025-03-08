<?php

namespace App\Providers;

use Zuno\DI\Container;

class AppServiceProvider extends Container
{
  /**
   * Register application services within the dependency injection container.
   *
   * This method serves as the central point for binding services, classes,
   * and other dependencies into the application's service container. By
   * registering services here, they become available for dependency
   * injection throughout the application's lifecycle.
   *
   * Common use cases include:
   * - Binding interfaces to concrete implementations.
   * - Registering service providers that offer additional functionality.
   * - Defining singletons or shared instances of classes.
   * - Configuring application-specific services.
   *
   * This method is automatically called during application bootstrapping.
   *
   * @return void
   */
  public function register(): void
  {
    // Place your service registration logic here.
  }
}
