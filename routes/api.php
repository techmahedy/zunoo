<?php

/*
|--------------------------------------------------------------------------
| Loading application api routes
|--------------------------------------------------------------------------
*/

use Zuno\Support\Facades\Route;
use Zuno\Http\Request;

Route::get('user', function (Request $request) {
    return $request->user();
});
