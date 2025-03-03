<?php

/*
|--------------------------------------------------------------------------
| Loading application web routes
|--------------------------------------------------------------------------
*/

use Zuno\Support\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', fn() => view('welcome'))->name('home');

/*
|--------------------------------------------------------------------------
| Auth Route
|--------------------------------------------------------------------------
*/
Route::get('/home', [HomeController::class, 'home'])->name('dashboard')->middleware('auth');
Route::get('/user/profile/{username}', [ProfileController::class, 'profile'])->name('profile')->middleware('auth');
Route::post('/update/profile', [ProfileController::class, 'updateProfile'])->name('profile.update')->middleware('auth');

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [RegisterController::class, 'index'])->name('register')->middleware('guest');
Route::post('/user/register', [RegisterController::class, 'register'])->name('register.create')->middleware('guest');
