<?php

/**
 * Application web routes
 */
use Mii\Route;

Route::get('/', function () {
    return view('welcome');
});