<?php

namespace App\Http\Controllers\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use NoCaptcha;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    
    public function login(Request $request)
    {
        if(Auth::check()){
            return redirect()->route('home'); 
        }
        return view("content.authentications.login");

    }

    public function signup(Request $request)
    {
        if(Auth::check()){
            return redirect()->route('home'); 
        }
        return view("content.authentications.signup");

    }

    public function dologin(Request $request)
    {
        $rules = [
            'username'     => 'required|string',
            'password'  => 'required|string',
        ];
    
        if (app()->environment('production')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
    
        $request->validate($rules);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        User::whereNotNull('email_verified_at')->where('status','pending')->update(['status' => 'active']);
        

        if (!Auth::guard()->attempt(array($fieldType => $request->username, 'password' => $request->password)))
        {   
            return back()->withErrors(['msg' => 'Username atau password tidak cocok!']);
        }
        
        if(Auth::user()->status != 'active'){
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return redirect()->route('auth')->withErrors(['msg' => 'Akun tidak aktif! Silahkan hubungi admin.']);
        }

        User::where('id',Auth::user()->id)->update(['last_login' => Carbon::now()->toDateTimeString()]);
        $request->session()->put('user_id', Auth::user()->id);
        if(Auth::user()->hasRole('member')){
            return redirect()->route('job-index');
        }
        return redirect()->route('home')->with('success', 'Your message has been sent successfully!');
            
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if($request->page=='landing'){
            return redirect()->route('landing');
        }

        return redirect()->route('auth')->with(['message' => 'Berhasil logout!']);
    }

    public function storeRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'min:8',
            'phone' => 'required',
            'gender' => 'in:Perempuan,Laki-laki'
        ]);

        $data_user = $request->only(
            'name',
            'username',
            'email',
            'password',
        );

        $data_profile = $request->only(
            'phone',
            'gender',
        );

        $data_user['password'] = Hash::make($data_user['password']);
        $data_user['status'] = 'active';
        $data_user['created_at'] = Carbon::now()->toDateTimeString();
        $data_user['updated_at'] = $data_user['created_at'];
        $data_profile['created_at'] = $data_user['created_at'];
        $data_profile['updated_at'] = $data_user['created_at'];
        
        $user = User::insertGetId(
            $data_user
        );

        $user = User::find($user);        
        $user->assignRole('relawan');
        $data_profile['user_id'] =  $user->id;
        UserProfile::insert([
            $data_profile
        ]);
            
        return jsend_success(['message' => 'Registrasi berhasil silahkan login.']);
    }

    public function dosignup(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'min:8',
            'phone' => 'required'
        ];
    
        if (app()->environment('production')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }
    
        $request->validate($rules);

        $data_user = $request->only(
            'name',
            'email',
            'password',
        );
        $data_user['username'] = $data_user['email'];

        $data_profile = $request->only(
            'phone',
        );

        $data_user['status'] = 'active';
        $data_user['password'] = Hash::make($data_user['password']);
        $data_user['created_at'] = Carbon::now()->toDateTimeString();
        $data_user['updated_at'] = $data_user['created_at'];
        $data_profile['created_at'] = $data_user['created_at'];
        $data_profile['updated_at'] = $data_user['created_at'];
        
        $user = User::insertGetId(
            $data_user
        );

        $user = User::find($user);        
        $user->assignRole('member');
        $data_profile['user_id'] =  $user->id;
        UserProfile::insert([
            $data_profile
        ]);
        //$user->sendEmailVerificationNotification();

        return redirect()->route('auth')->with(['message' => 'Registrasi berhasil silahkan Login!']);
    }
}
