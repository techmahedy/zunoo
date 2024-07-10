<?php

/**
 * Application web routes
 */

use App\Http\Controllers\ExampleController;
use Mii\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/connection', [ExampleController::class, 'index']);
