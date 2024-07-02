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

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

/**
 * Start the application session
 */
session_start();

/**
 * Loading the spatie error page handler
 */
Ignition::make()->useDarkMode()->register();

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

// Set the event dispatcher used by Eloquent models... (optional)
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
*/
$app = new Application(
    new Route(new Request()),
    new Middleware()
);

/*
|--------------------------------------------------------------------------
| Return The Application
|--------------------------------------------------------------------------
*/
return $app;
