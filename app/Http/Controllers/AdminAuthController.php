<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM LOGIN ADMIN
    |--------------------------------------------------------------------------
    */

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /*
    |--------------------------------------------------------------------------
    | PROSES LOGIN ADMIN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => [
                'required',
                'email',
            ],

            'password' => [
                'required',
                'string',
            ],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {

            $request->session()->regenerate();

            return redirect()
                ->intended(route('admin.dashboard'))
                ->with('success', 'Login berhasil.');
        }

        return back()
            ->withErrors([
                'email' => 'Email atau password yang dimasukkan salah.',
            ])
            ->onlyInput('email');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT ADMIN
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda berhasil logout.');
    }
}