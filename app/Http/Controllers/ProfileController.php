<?php

namespace App\Http\Controllers;

use Zuno\Http\Request;
use Zuno\Auth\Security\Auth;
use App\Models\User;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function profile(string $username)
    {
        return view('user.profile', compact('username'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'first_name' => 'required|min:2|max:20',
            'last_name' => 'required|min:2|max:20'
        ]);

        $user = User::find(Auth::user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->save();

        flash()->message('success', 'Profile updated sucessfully');

        return redirect()->back();
    }
}
