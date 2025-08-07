<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\BusinessCategory;
use App\Models\BusinessField;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;

class ProfileController extends Controller
{
    public function index()
    {
        $page = 'Index';
        $result = User::find(Auth::user()->id);

        return view('content.user.profile.form', data: compact('page', 'result'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'password' => ($request->password) ? 'min:8' : '',
            'phone' => 'required',
        ]);

        $data_user = $request->only(
            'name',
        );

        

        $data_profile = $request->only(
            'phone'
        );

        $data_profile['nip']  = $request->nip ? $request->nip : null;
        $data_profile['address'] = $request->address ? $request->address : null;
        $data_profile['gender'] = $request->gender ? $request->gender : null;
        $data_profile['birth_date'] = $request->birth_date ? $request->birth_date : null;
        
        if($request->img_url){
            $request->validate([
                'img_url' => 'required|mimes:jpg,png|max:2048',
            ]);
            $fileName = 'user_profile'.time().'.'.$request->img_url->extension();
            $request->img_url->move(storage_path('app/cloudfolder/images'), $fileName);
            $data_profile['img_url'] = $fileName;
        }

        if ($request->password) $data_user['password'] = Hash::make($request->password);
        $data_user['updated_at'] = Carbon::now()->toDateTimeString();
        $data_profile['updated_at'] = $data_user['updated_at'];
        
        $id = Auth::user()->id;

        User::where('id',$id)->update(
            $data_user
        );
        
        UserProfile::where('user_id',$id)->update(
            $data_profile
        );

        return to_route('profile-index')->with(['success' => 'Data telah diperbarui!']);
    }
}
