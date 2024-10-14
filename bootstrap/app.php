<?php

use Dotenv\Dotenv;
use Mii\Route;
use Mii\Request;
use Mii\Application;
use Spatie\Ignition\Ignition;
use Illuminate\Events\Dispatcher;
use Mii\Middleware\Middleware;
use Illuminate\Container\Container;
use Illuminate\Database\Capsule\Manager as Capsule;
use Mii\Container as MiiContainer;

// Load environment variables from .env file
$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

/**
 * Start the application session
 */
session_start();

/**
 * Register the Spatie Ignition error page handler with dark mode enabled
 */
Ignition::make()->useDarkMode()->register();

/**
 * Setup database connection using Eloquent ORM and Capsule Manager
 */
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => $_ENV['DB_CONNECTION'],
    'host'      => $_ENV['DB_HOST'],
    'database'  => $_ENV['DB_DATABASE'],
    'username'  => $_ENV['DB_USERNAME'],
    'password'  => $_ENV['DB_PASSWORD'],
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
    new MiiContainer
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
