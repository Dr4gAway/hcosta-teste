<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

Use App\Models\User;

class SignUpController extends Controller
{
    public function create() {
        return view('auth.signup');
    }

    public function store(Request $request) {

        $data = $request->validate([
                    'name' => 'required|string',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|string|min:8|max:32'
                ]);

        User::create($data);
        Auth::attempt($data);

        return redirect('/');
    }
}
