<?php

use App\Http\Kernel;

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/bootstrap/app.php';

require __DIR__ . '/routes/web.php';

/*
|--------------------------------------------------------------------------
| Checking application global middleware
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
