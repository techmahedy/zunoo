<?php

use App\Core\Application;
use App\Http\Controllers\ExampleController;

$app->route->get('/register', [ExampleController::class, 'index']);
$app->route->post('/register', [ExampleController::class, 'store']);

$app->route->get('/', function () {

    $version = Application::VERSION;

    return view('welcome', compact('version'));
});
