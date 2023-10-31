<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Core\Request;
use App\Core\Controllers\Controller;

class ExampleController extends Controller
{
    public function __construct(User $user)
    {
        # code...
    }

    public function index(Request $request)
    {
        return "wow";
    }
}
