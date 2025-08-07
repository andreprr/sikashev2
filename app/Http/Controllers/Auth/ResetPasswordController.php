<?php
// app/Http/Controllers/Auth/ResetPasswordController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function reset(Request $request)
    {
        $rules = [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ];
    
        if (app()->environment('production')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
    
        $request->validate($rules);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('auth')->with(['message' => 'Reset Password Berhasil! Silakan Login menggunakan Password Baru!'])
                    : back()->withErrors(['email' => [__($status)]]);
    }
}
