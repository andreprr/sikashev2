<?php

namespace App\Http\Controllers\prestasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplicantsJob;

class ApplicantsJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = ApplicantsJob::where([
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

        return view('content.applicantsjob.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'Tambah';
        return view('content.applicantsjob.form', compact('page'));
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

        ApplicantsJob::insert([
            $input
        ]);


        return to_route('ApplicantsJob-index')->with(['success' => 'Data '.$input['name'].' telah berhasil disimpan!']);
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
        $result = ApplicantsJob::find($id);
        return view('content.applicantsjob.form', compact('page', 'result'));
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

        ApplicantsJob::where('id',$id)->update(
            $input
        );

        return to_route('ApplicantsJob-index')->with(['success' => 'Data '.$input['name'].' telah berhasil disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = ApplicantsJob::find($id);
        if($result){
            ApplicantsJob::destroy($id);
            return redirect()->route('ApplicantsJob-index')->with(['success' => 'Data '.$result->ApplicantsJob.' Berhasil Dihapus!']);
        }else{
            return redirect()->route('ApplicantsJob-index')->with(['fail' => 'Data Tidak Ditemukan']);
        }
    }
}
