<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Core\Request;
use App\Core\Controllers\Controller;

class ExampleController extends Controller
{
    public function index(User $user)
    {
        return view('user.index', compact('user'));
    }

    public function store(User $user, Request $request)
    {
        $user->old($request->getBody());

        if ($user->validated()) {
            return "Success";
        }

        return view('user.index', compact('user'));
    }
}
