<?php

namespace App\Http\Controllers;

use App\Core\Controllers\Controller;

class ExampleController extends Controller
{
    public function index()
    {
        $title = 'blade test';

        return view('home.index', compact('title'));
    }
}
