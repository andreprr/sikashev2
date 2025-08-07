<?php

namespace App\Http\Controllers\prestasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ResearchField;

class ResearchFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = ResearchField::where([
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

        return view('content.researchfield.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'Tambah';
        return view('content.researchfield.form', compact('page'));
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

        ResearchField::insert([
            $input
        ]);


        return to_route('ResearchField-index')->with(['success' => 'Data '.$input['name'].' telah berhasil disimpan!']);
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
        $result = ResearchField::find($id);
        return view('content.researchfield.form', compact('page', 'result'));
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

        ResearchField::where('id',$id)->update(
            $input
        );

        return to_route('ResearchField-index')->with(['success' => 'Data '.$input['name'].' telah berhasil disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = ResearchField::find($id);
        if($result){
            ResearchField::destroy($id);
            return redirect()->route('ResearchField-index')->with(['success' => 'Data '.$result->ResearchField.' Berhasil Dihapus!']);
        }else{
            return redirect()->route('ResearchField-index')->with(['fail' => 'Data Tidak Ditemukan']);
        }
    }
}
