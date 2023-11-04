<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Core\Request;

class ExampleController extends Controller
{
    public function index(User $user)
    {
        return view('welcome', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        $user->old($request->getBody());

        if ($user->validated()) {
            //Validation passed
            return redirect('/');
        }

        return view('welcome', compact('user'));
    }
}
