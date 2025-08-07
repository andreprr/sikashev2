<?php
// app/Http/Controllers/Auth/EmailVerificationController.php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class EmailVerificationController extends Controller
{
    public function verify(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home')->with('message', 'Your email is already verified.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('home')->with('message', 'Your email has been verified.');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    public function verifyEmail(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->route('home')->with('message', 'Your email is already verified.');
        }else{
            $user = User::where('email', Crypt::decryptString($request->token))
                    ->firstOrFail();

            if(!$user){
                return abort(404);
            }

            if (!$user->hasVerifiedEmail()) {
                $user->markEmailAsVerified();
                // You can add a success message or redirect
            }

            return redirect()->route('home')->with('message', 'Your email has been verified.');
        }

       
    }
}
