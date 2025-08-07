<?php

namespace App\Http\Controllers\form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Opd;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $opd = Auth::user()->hasRole('opd') ? Auth::user()->opd->opd_id : '';
        $results = Job::join('opd', 'opd.id', '=', 'jobs.opd_id')->where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query->orWhere('job', 'LIKE', '%' . $filter . '%')
                        ->orWhere('description', 'LIKE', '%' . $filter . '%')
                        ->orWhere('opd', 'LIKE', '%' . $filter . '%')
                        ->orWhere('type', 'LIKE', '%' . $filter . '%')
                        ->orWhere('status', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])->when($opd, function ($query, $opd) {
            return $query->where('opd.id', $opd);
        })->when(Auth::user()->hasRole('member'), function ($query) {
            return $query->where('status','!=','draft');
        })
        ->select('jobs.*', 'opd.name as opd')->orderBy('updated_at', 'desc')
        ->paginate(10);

        $filter = $request->filter;
        $results->appends(['filter' => $filter]);

        return view('content.job.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'Tambah';
        $types = Job::select('type')->groupBy('type')->get();
        $studys = Job::select('study')->groupBy('study')->get();
        $opds = Opd::get();
        return view('content.job.form', compact('page','types','studys','opds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'job' => 'required|max:255',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'requirement' => 'required',
            'opd_id' => (Auth::user()->hasRole('admin')) ? 'required' : ''
        ]);

        $input = $request->only(
            'job',
            'skill',
            'requirement',
            'start_date',
            'end_date',
            'description'
        );

        $input['type'] = '';
        if($request->type){
            $input['type'] = json_encode($request->type);
        }
        $input['study'] = '';
        if($request->type){
            $input['study'] = json_encode($request->study);
        }

        if(Auth::user()->hasRole('admin')){
            $input['opd_id'] = $request->opd_id;
        }

        Job::insert([
            $input
        ]);


        return to_route('job-index')->with(['success' => 'Data '.$input['job'].' telah berhasil disimpan!']);
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
        $types = Job::select('type')->groupBy('type')->get();
        $studys = Job::select('study')->groupBy('study')->get();
        $opds = Opd::get();

        $result = Job::find($id);
        return view('content.job.form', compact('page', 'result', 'types', 'studys', 'opds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'job' => 'required|max:255',
            'type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'requirement' => 'required',
            'opd_id' => (Auth::user()->hasRole('admin')) ? 'required' : ''
        ]);

        $input = $request->only(
            'job',
            'skill',
            'requirement',
            'start_date',
            'end_date',
            'description'
        );

        $input['type'] = '';
        if($request->type){
            $input['type'] = json_encode($request->type);
        }
        $input['study'] = '';
        if($request->type){
            $input['study'] = json_encode($request->study);
        }

        if(Auth::user()->hasRole('admin')){
            $input['opd_id'] = $request->opd_id;
        }

        Job::where('id',$id)->update(
            $input
        );

        return to_route('job-index')->with(['success' => 'Data '.$input['job'].' telah berhasil disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Job::find($id);
        if($result){
            Job::destroy($id);
            return redirect()->route('job-index')->with(['success' => 'Data '.$result->job.' Berhasil Dihapus!']);
        }else{
            return redirect()->route('job-index')->with(['fail' => 'Data Tidak Ditemukan']);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        $data =$request->only('status');
        if($data['status'] == 'publish'){
            $data['published_at'] = Carbon::now()->toDateTimeString();
        }
        $data['updated_at'] = Carbon::now()->toDateTimeString();
        Job::updateOrInsert(
            ['id' => $id],
            $data
        );
        return redirect()->route('job-index')->with(['success' => 'Data Berhasil diperbarui!']);
    }
}
