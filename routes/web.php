<?php

/*
|--------------------------------------------------------------------------
| Loading application web routes
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\AppTestController;
use Zuno\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');