<?php

/**
 * Application web routes
 */

use App\Core\Application;

$app->route->get('/', function () {

    $version = Application::VERSION;

    return view('welcome', compact('version'));
});
