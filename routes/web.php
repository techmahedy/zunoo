<?php

use App\Core\Application;
use App\Http\Controllers\TestController;

$app->route->get('/', [TestController::class, 'index']);

// $app->route->get('/', function () {

//     $version = Application::VERSION;

//     return view('welcome', compact('version'));
// });
