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

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:user|min:2|max:100',
            'first_name' => 'required|min:2|max:100',
            'last_name' => 'required|min:2|max:100',
            'address' => 'required|min:2|max:250'
        ]);

        //save the data

        return redirect()->url('/test');
    }
}
