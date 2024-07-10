<?php

namespace App\Providers;

use App\Interface\ConnectionInterface;
use App\Service\MySQLConnection;
use Mii\Container;

class AppServiceProvider extends Container
{
  /**
   * Register any application services.
   */
  public function register()
  {
    $this->bind(ConnectionInterface::class, MySQLConnection::class);
  }
}
