<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
    use Illuminate\Routing\Controller;

class LoginController extends Controller
{
    public function create() {
        return view('auth.login');
    }

    public function store(Request $request){
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:32'
        ]);

        if (Auth::attempt($data)) {
            return redirect('/');
        }

        return back()->withErrors([
            'invalid_credentials' => 'As credênciais são invalidas',
        ])->withInput();
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
