<?php

namespace App\Core;

use App\Core\Route;
use App\Core\Request;
use App\Providers\AppServiceProvider;

class Application extends AppServiceProvider
{
    public Route $route;
    public $resolveDependency;

    public function __construct()
    {
        $this->resolveDependency = $this->register();
        $this->route = new Route(new Request());
    }

    public function run()
    {
        echo $this->route->resolve($this->resolveDependency);
    }
}
