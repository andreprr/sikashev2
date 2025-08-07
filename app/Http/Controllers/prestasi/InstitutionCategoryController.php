<?php

namespace App\Http\Controllers\prestasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstitutionCategory;

class InstitutionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = InstitutionCategory::where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query->orWhere('name', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])->orderBy('name', 'asc')
        ->paginate(10);

        $filter = $request->filter;
        $results->appends(['filter' => $filter]);

        return view('content.institutioncategory.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'Tambah';
        return view('content.institutioncategory.form', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:business_fields|max:255',
            'description' => 'required'
        ]);

        $input = $request->only(
            'name',
            'description'
        );

        InstitutionCategory::insert([
            $input
        ]);


        return to_route('InstitutionCategory-index')->with(['success' => 'Data '.$input['name'].' telah berhasil disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $page = 'Edit';
        $result = InstitutionCategory::find($id);
        return view('content.institutioncategory.form', compact('page', 'result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => [
                'required',
                'max:255',
                Rule::unique('business_fields')->ignore($id)
            ],
            'description' => 'required'
        ]);

        $input = $request->only(
            'name',
            'description'
        );

        InstitutionCategory::where('id',$id)->update(
            $input
        );

        return to_route('InstitutionCategory-index')->with(['success' => 'Data '.$input['name'].' telah berhasil disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = InstitutionCategory::find($id);
        if($result){
            InstitutionCategory::destroy($id);
            return redirect()->route('InstitutionCategory-index')->with(['success' => 'Data '.$result->institutioncategory.' Berhasil Dihapus!']);
        }else{
            return redirect()->route('InstitutionCategory-index')->with(['fail' => 'Data Tidak Ditemukan']);
        }
    }
}
