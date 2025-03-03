<?php

use App\Http\Kernel;

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

require __DIR__ . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/
require __DIR__ . '/bootstrap/app.php';

require __DIR__ . '/routes/web.php';

/*
|--------------------------------------------------------------------------
| Handling the client Request
|--------------------------------------------------------------------------
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
*/

$kernel = $app->make(Kernel::class);
$kernel->send();

/*
|--------------------------------------------------------------------------
| Run the application
|--------------------------------------------------------------------------
*/

$app->run();
