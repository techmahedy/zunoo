<?php

use App\Http\Kernel;

define('ZUNO_START', microtime(true));

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/bootstrap/app.php';

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
