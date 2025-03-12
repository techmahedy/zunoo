<?php

use Zuno\Application;

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we create the application instance, providing it with the necessary
| components: Route, Request, Middleware and Container.
|
*/

$basePath = env('APP_BASE_PATH') ?? dirname(__DIR__);

define('BASE_PATH', $basePath);

$app = Application::configure($basePath)->build();

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
