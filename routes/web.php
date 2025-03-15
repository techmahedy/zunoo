<?php

/*
|--------------------------------------------------------------------------
| Loading application web routes
|--------------------------------------------------------------------------
*/

use Zuno\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');