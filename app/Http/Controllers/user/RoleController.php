<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $results = Role::where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query->orWhere('name', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])->orderBy('name', 'asc')
        ->paginate(10);
        $filter = $request->filter;

        return view('content.user.role.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = 'Tambah';
        $permissions = Permission::get();
        return view('content.user.role.form', compact('page','permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only('name','guard_name');
        $role = Role::create($data);

        $role->syncPermissions($request->permission);

        return to_route('role-index')->with(['success' => 'Data telah berhasil disimpan!']);
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
        $result = Role::find($id);
        $permissions = Permission::get();

        return view('content.user.role.form', compact('page', 'result', 'permissions'));
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
        $data = $request->only('name','guard_name');
        
        $role = Role::where('id',$id)->update(
            $data
        );

        $role = Role::find($id);
        $role->syncPermissions($request->permission);

        return to_route('role-index')->with(['success' => 'Data telah diperbarui!']);
    }
}
