<?php

namespace App\Http\Controllers;

use App\Core\Rule;
use App\Models\User;
use App\Core\Request;
use Illuminate\Support\Facades\DB;

class ExampleController extends Controller
{
    public function index(User $user)
    {
        return view('welcome', compact('user'));
    }

    public function store(Request $request, User $user)
    {
        $validation = $request->validate($_REQUEST, [
            'email' => 'required|email|unique:user|min:2|max:100',
            'first_name' => 'required|min:2|max:100',
            'last_name' => 'required|min:2|max:100',
            'address' => 'required|min:2|max:250'
        ]);

        dd($validation);

        return view('welcome', compact('user'));
    }
}
