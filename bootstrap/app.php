<?php

use Dotenv\Dotenv;
use Zuno\Route;
use Zuno\Request;
use Zuno\Application;
use Illuminate\Events\Dispatcher;
use Zuno\Middleware\Middleware;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Zuno\Container as ZunoContainer;
use Zuno\Error\ErrorHandler;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

/**
 * Start the application session
 */
session_start();

// Zuno error handler
ErrorHandler::handle();

/**
 * Setup database connection using Eloquent ORM and Capsule Manager
 */
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => env('DB_CONNECTION'),
    'host'      => env('DB_HOST'),
    'database'  => env('DB_DATABASE'),
    'username'  => env('DB_USERNAME'),
    'password'  => env('DB_PASSWORD'),
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models (optional but recommended)
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods (optional)
$capsule->setAsGlobal();

// Boot Eloquent ORM (required to use Eloquent features)
$capsule->bootEloquent();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we create the application instance, providing it with the necessary
| components: Route, Request, Middleware and Container.
|
*/
$app = new Application(
    new Route(new Request()),
    new Middleware(),
    new ZunoContainer
);


/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
|
| Finally, we return the application instance. This will be used to handle
| incoming requests and send responses back to the client.
|
*/
return $app;
