<?php

use App\Core\Application;
use App\Http\Controllers\ExampleController;

$app->route->get('/', [ExampleController::class, 'index']);

// $app->route->get('/', function () {

//     $version = Application::VERSION;

//     return view('welcome', compact('version'));
// });
