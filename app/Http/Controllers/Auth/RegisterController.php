<?php

namespace App\Http\Controllers\Auth;

use Zuno\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users|min:2|max:100',
            'password' => 'required|min:2|max:20',
            'username' => 'required|unique:users|min:2|max:100',
            'first_name' => 'required|min:2|max:20',
            'last_name' => 'required|min:2|max:20',
        ]);

        $user = User::create($request->all());
        if ($user) {
            flash()->message('success', 'User created successfully');
            return redirect()->url('/login');
        }

        return redirect()->back();
    }
}
