<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!in_array($request->path(),['myprofile','myprofile/update'])) {
            if (!Auth::user()->profile->nip && Auth::user()->roles->pluck('name')->implode(',') != 'admin') {
                return to_route('profile-index')->with('error', 'Silahkan lengkapkan profil anda untuk mengakses aplikasi ini!');
            }
        }

        return $next($request);
    }
}
