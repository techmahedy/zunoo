<?php

namespace App\Http\Controllers\Auth;

use Zuno\Auth\Security\Auth;
use Zuno\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginController extends Controller
{
    use Auth;

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email|min:2|max:100',
            'password' => 'required|min:2|max:20',
        ]);

        $user = User::where('email', $request->email)
            ->first();

        if ($user) {
            if (Auth::attempt($request->all())) {
                session()->flash('message', 'You are logged in');
                return redirect()->url('/home');
            }
            session()->flash('message', 'Email or password is not matched');
            return redirect()->back();
        }

        session()->flash('message', 'User does not exists');
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('message', 'You are successfully logout');

        return redirect()->url('/login');
    }
}
