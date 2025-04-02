<?php

/*
|--------------------------------------------------------------------------
| Loading application web routes
|--------------------------------------------------------------------------
*/

use Zuno\Support\Facades\Route;

Route::get('/', fn() => view('welcome'))->name('home');


// Auth Routes
Route::get('/home', [\App\Http\Controllers\HomeController::class, 'home'])->name('dashboard')->middleware('auth');
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/user/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.create')->middleware('guest');
