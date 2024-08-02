<?php

/*
|--------------------------------------------------------------------------
| Loading application web routes
|--------------------------------------------------------------------------
*/

use Mii\Route;

// Define a route for the root URL that returns the welcome view
Route::get('/', fn () => view('welcome'));
