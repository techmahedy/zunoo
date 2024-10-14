<?php

/*
|--------------------------------------------------------------------------
| Loading application web routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\ExampleController;
use Mii\Route;

Route::get('/', fn() => view('welcome'));

Route::get('/test', [ExampleController::class, 'index']);
