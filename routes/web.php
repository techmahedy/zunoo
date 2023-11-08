<?php

/**
 * Application web routes
 */

use App\Core\Route;
use App\Core\Application;

Route::get('/', function () {
    $version = Application::VERSION;

    return view('welcome', compact('version'));
});
