<?php

use App\Http\Kernel;

define('Zuno_START', microtime(true));

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/bootstrap/app.php';

require __DIR__ . '/routes/web.php';

/*
|--------------------------------------------------------------------------
| Loading application global middleware
|--------------------------------------------------------------------------
*/
foreach ((new Kernel)->middleware as $key => $middeware) {
    $app->applyMiddleware(new $middeware);
}

/*
|--------------------------------------------------------------------------
| Run the application
|--------------------------------------------------------------------------
*/

$app->run();
