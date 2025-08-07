<?php

namespace App\Http\Controllers\Api\authentications;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    
    public function dologin(Request $request)
    {
        
        $request->validate([
            'username'     => 'required|string',
            'password'  => 'required|string',
        ]);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if (!Auth::guard()->attempt(array($fieldType => $request->username, 'password' => $request->password)))
        {
            return jsend_fail(["message" => "Username atau password tidak cocok"], 401);
        }
        
        if(Auth::user()->status != 'active'){
            $token = Auth::user()->tokens()->first();
            if($token){
                Auth::user()->tokens()->delete();
            }
            
            return jsend_fail(["message" => "Akun tidak aktif! Silahkan hubungi admin."], 401);
        }

        $token = Auth::user()->tokens()->first();

        User::where('id',Auth::user()->id)->update(['last_login' => Carbon::now()->toDateTimeString()]);
        $user = User::where('id',Auth::user()->id)->select('id','name','email','username','status')->first();
        
        $token = Auth::user()->tokens()->first();
        if($token){
            Auth::user()->tokens()->delete();
        }

        $expires_at = now()->addMinutes(1440);
        $token = $user->createToken(name: $request->client_id, 
        expiresAt: $expires_at)->plainTextToken;

        $user['role'] = $user->roles->pluck('name')->implode(',');
        unset($user->roles);
        return jsend_success(['message' => 'Hi! '.$user->name.', welcome to application','user' => $user,'access_token' => $token, 'expires_at' => $expires_at->format("Y-m-d H:i:s"), 'token_type' => 'Bearer'], 200);
            
    }

    public function logout(Request $request)
    {   
        $request->validate([
            'id' => 'required'
        ]);

        DB::table('personal_access_tokens')->where('tokenable_id',$request->id)->delete();
        //$user = $request->user();
        //$user->currentAccessToken()->delete();
        
        return jsend_success(['Berhasil Logout!'], 200);
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
            
        return jsend_success(['message' => 'Registrasi berhasil.']);
    }
}
