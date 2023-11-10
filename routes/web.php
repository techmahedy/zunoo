<?php

/**
 * Application web routes
 */

use App\Core\Route;

Route::get('/', function () {
    return view('welcome');
});