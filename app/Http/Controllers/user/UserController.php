<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserProfile;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule as ValidationRule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\BusinessCategory;
use App\Models\BusinessField;
use App\Models\Opd;
use App\Models\UserOpd;
use DB;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('can:manage.user');
    }

    public function index(Request $request)
    {
        $results = User::where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query->orWhere('name', 'LIKE', '%' . $filter . '%')
                        ->orWhere('email', 'LIKE', '%' . $filter . '%')
                        ->orWhere('username', 'LIKE', '%' . $filter . '%')
                        ->orWhere('status', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])->orderBy('created_at', 'desc')
        ->paginate(10);

        $filter = $request->filter;
        $results->appends(['filter' => $filter]);

        return view('content.user.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'Tambah';
        $roles = Role::get();

        $business_field = BusinessField::all();
        $business_category = BusinessCategory::all();
        return view('content.user.form', compact('page','roles', 'business_field', 'business_category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'phone' => 'required',
        ]);

        $data_user = $request->only(
            'name',
            'username',
            'email',
            'password',
        );

        $data_profile = $request->only(
            'phone'
        );

        $data_profile['nip']  = $request->nip ? $request->nip : null;
        $data_profile['pangkat'] = $request->pangkat ? $request->pangkat : null;
        $data_profile['jabatan'] = $request->jabatan ? $request->jabatan : null;
        $data_profile['pendidikan'] = $request->pendidikan ? $request->pendidikan : null;
        $data_profile['satker'] = $request->satker ? $request->satker : null;
        $data_profile['instansi'] = $request->instansi ? $request->instansi : null;
        $data_profile['address'] = $request->address ? $request->address : null;

        if($request->img_url){
            $request->validate([
                'img_url' => 'required|mimes:jpg,png|max:2048',
            ]);
            $fileName = 'user_profile'.time().'.'.$request->img_url->extension();
            $request->img_url->move(storage_path('app/cloudfolder/images'), $fileName);
            $data_profile['img_url'] = $fileName;
        }

        $data_user['password'] = Hash::make($data_user['password']);
        $data_user['created_at'] = Carbon::now()->toDateTimeString();
        $data_user['updated_at'] = $data_user['created_at'];
        $data_profile['created_at'] = $data_user['created_at'];
        $data_profile['updated_at'] = $data_user['created_at'];

        $user = User::insertGetId(
            $data_user
        );

        $user = User::find($user);
        $user->assignRole($request->role);
        $data_profile['user_id'] =  $user->id;
        UserProfile::insert([
            $data_profile
        ]);

        return to_route('user-index')->with(['success' => 'Data telah berhasil disimpan!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = 'Edit';
        $result = User::find($id);
        $roles = Role::get();
        $opds = Opd::get();

        return view('content.user.form', compact('page', 'result', 'roles','opds'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'password' => ($request->password) ? 'min:8' : '',
            'username' => [
                'required',
                ValidationRule::unique('users')->ignore($id)
            ],
            'email' => [
                'required',
                'email',
                ValidationRule::unique('users')->ignore($id)
            ],
            'role' => 'required',
            'phone' => 'required',
        ]);

        $data_user = $request->only(
            'name',
            'username',
            'email'
        );

        $data_profile = $request->only(
            'phone',
        );

        $data_profile['nik']  = $request->nik ? $request->nik : null;
        $data_profile['birth_date'] = $request->birth_date ? $request->birth_date : null;
        $data_profile['gender'] = $request->gender ? $request->gender : null;
        $data_profile['address'] = $request->address ? $request->address : null;

        if($request->img_url){
            $request->validate([
                'img_url' => 'required|mimes:jpg,png|max:2048',
            ]);
            $fileName = 'user_profile'.time().'.'.$request->img_url->extension();
            $request->img_url->move(storage_path('app/cloudfolder/images'), $fileName);
            $data_profile['img_url'] = $fileName;
        }

        UserOpd::where('user_id', $id)->delete();
        if($request->role == 'opd'){
            UserOpd::updateOrinsert(
                ['user_id' => $id,'opd_id' => $request->user_opd],
                ['user_id' => $id,'opd_id' => $request->user_opd,'updated_at' => Carbon::now()->toDateTimeString()]
            );
        }

        if ($request->password) $data_user['password'] = Hash::make($request->password);
        $data_user['updated_at'] = Carbon::now()->toDateTimeString();;
        $data_profile['birth_date'] =  $data_profile['birth_date'] ? new Carbon( $data_profile['birth_date']) : null;
        $data_profile['updated_at'] = $data_user['updated_at'];

        $user = User::where('id',$id)->update(
            $data_user
        );

        $user = User::find($id);

        $user->syncRoles($request->role);

        UserProfile::where('user_id',$user->id)->update(
            $data_profile
        );

        return to_route('user-index')->with(['success' => 'Data telah diperbarui!']);
    }

    public function changeStatus(Request $request, $id)
    {
        $data =$request->only('status');
        User::updateOrInsert(
            ['id' => $id],
            $data
        );
        return redirect()->route('user-index')->with(['success' => 'Data Berhasil diperbarui!']);
    }
    public function verifymanual(Request $request, $id){
        $user = User::find($id);
        $user->email_verified_at = Carbon::now()->toDateTimeString();
        $user->save();
        return redirect()->route('user-index')->with(['success' => 'Data Berhasil diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('user-index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function getProfile(Request $request)
    {
        $results = User::where('id',Auth::user()->id)->select('id','name','email','username','status')->first();
        $results['role'] = $results->roles->pluck('name')->implode(',');
        unset($results->roles);
        $path = route('getimage','');
        $results->profile = UserProfile::where('user_id',Auth::user()->id)->selectRaw('nik,nip,gender,phone,birth_date,address, concat("'.$path.'/",img_url) as img_url')->first();

        return jsend_success($results);
    }

    public function setProfile(Request $request)
    {
        $id = Auth::user()->id;

        $request->validate([
            'name' => 'required',
            'password' => ($request->password) ? 'required|confirmed|min:8|different:current_password' : '',
            'password_confirmation' => ($request->password) ? 'min:8' : '',
            'current_password' => ($request->password) ? ['required', function ($attribute, $value, $fail) use ($request) {
                if (!Hash::check($request->current_password, Auth::user()->password)) {
                    return $fail(__('The current password is incorrect.'));
                }
            }] : '',
            'phone' => 'required',
            'gender' => 'in:Perempuan,Laki-laki'
        ]);

        $data_user = $request->only(
            'name',
        );

        $data_profile = $request->only(
            'nik',
            'nip',
            'phone',
            'birth_date',
            'gender',
            'address',
        );

        if ($request->password) $data_user['password'] = Hash::make($request->password);

        $data_user['updated_at'] = Carbon::now()->toDateTimeString();;
        $data_profile['birth_date'] =  $data_profile['birth_date'] ? new Carbon( $data_profile['birth_date']) : null;
        if ($request->img_url) $data_profile['img_url'] = $request->img_url;
        $data_profile['updated_at'] = $data_user['updated_at'];

        User::where('id',$id)->update(
            $data_user
        );

        UserProfile::where('user_id',$id)->update(
            $data_profile
        );

        return jsend_success(['message' => 'Data berhasil di simpan.']);
    }

    public function resetlogin(Request $request)
    {
        $request->validate([
            'id' => (!$request->state == 'all') ? 'required' : ''
        ]);

        if($request->state == 'all'){
            DB::table('personal_access_tokens')->delete();
        }else{
            DB::table('personal_access_tokens')->where('tokenable_id',$request->id)->delete();
        }

        return to_route('user-index')->with(['success' => 'Reset login berhasil!']);
    }
}
