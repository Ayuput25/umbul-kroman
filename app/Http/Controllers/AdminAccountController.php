<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminAccountController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM AKUN
    |--------------------------------------------------------------------------
    */

    public function edit(Request $request)
    {
        $user = $request->user();

        return view('admin.account.edit', compact('user'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PROFIL ADMIN
    |--------------------------------------------------------------------------
    */

    public function updateProfile(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'max:255',

                Rule::unique('users', 'email')
                    ->ignore($user->id),
            ],
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        return redirect()
            ->route('admin.account.edit')
            ->with(
                'success',
                'Informasi akun berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PASSWORD
    |--------------------------------------------------------------------------
    */

    public function updatePassword(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'current_password' => [
                'required',
                'string',
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        if (
            !Hash::check(
                $validated['current_password'],
                $user->password
            )
        ) {
            return back()
                ->withErrors([
                    'current_password' =>
                        'Password saat ini tidak sesuai.',
                ])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make(
                $validated['password']
            ),
        ]);

        return redirect()
            ->route('admin.account.edit')
            ->with(
                'success',
                'Password berhasil diperbarui.'
            );
    }
}