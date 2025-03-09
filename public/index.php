<?php

define('ZUNO_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__ . '/../vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Bootstrap application services
|--------------------------------------------------------------------------
*/
require __DIR__ . '/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Send the request
|--------------------------------------------------------------------------
*/
$app->handle()->send();

/*
|--------------------------------------------------------------------------
| Get the response for client
|--------------------------------------------------------------------------
*/
$app->run();
