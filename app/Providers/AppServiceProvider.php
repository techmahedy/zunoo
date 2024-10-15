<?php

namespace App\Providers;

use Zuno\Container;

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
    // Register any custom blade directives, macro or your own custom builds
    //
    // Place service bindings or provider registrations here.
    //
    // Example:
    // $this->bind(SomeService::class, function() {
    //     return new SomeService();
    // });
  }
}
