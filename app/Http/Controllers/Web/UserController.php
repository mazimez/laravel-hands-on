<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (! $user) {
            return back()->withErrors(['email' => 'Email not found']);
        }
        if (! password_verify($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Wrong password']);
        }
        Auth::login($user);

        return redirect('/dashboard');
    }

    public function show(Request $request)
    {
        return view('UI.users', [
            'page_title' => 'Users',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
