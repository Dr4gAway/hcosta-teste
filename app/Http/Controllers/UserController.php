<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;


use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

Use App\Models\User;

class UserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    public function create() {
        return view('profile');
    }

    public function update(Request $request) {
        $this->authorize('update', Auth::user());

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email'
        ]);

        User::where('id', Auth::id())->update($data);
    }

    public function delete(Request $request) {
        $this->authorize('delete', Auth::user());

        $user = User::where('id', Auth::id());
        
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
