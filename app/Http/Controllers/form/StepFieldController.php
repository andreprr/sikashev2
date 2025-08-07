<?php

namespace App\Http\Controllers\form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StepField;
use App\Models\EventStep;
use Illuminate\Validation\Rule;
class StepFieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //['step_id','event_id','field_name','field_description','field_order','field_type','allowed_type','default_value','model_referer','need_verif']
        $results = StepField::selectRaw('step_fields.*,events.event,events.description,event_steps.event_step,step_description')->where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query->rightjoin('event_steps','event_steps.id','step_fields.step_id')
                        ->rightjoin('events','events.id','event_steps.event_id')
                        ->orWhere('step_fields.field_name', 'LIKE', '%' . $filter . '%')
                        ->orWhere('step_fields.field_description', 'LIKE', '%' . $filter . '%')
                        ->orWhere('step_fields.field_order', 'LIKE', '%' . $filter . '%')
                        ->orWhere('step_fields.field_type', 'LIKE', '%' . $filter . '%')
                        ->orWhere('step_fields.allowed_type', 'LIKE', '%' . $filter . '%')
                        ->orWhere('step_fields.default_value', 'LIKE', '%' . $filter . '%')
                        ->orWhere('step_fields.model_referer', 'LIKE', '%' . $filter . '%')
                        ->orWhere('step_fields.need_verif', 'LIKE', '%' . $filter . '%')
                        ->orWhere('event_steps.event_step', 'LIKE', '%' . $filter . '%')
                        ->orWhere('event_steps.step_description', 'LIKE', '%' . $filter . '%')
                        ->orWhere('events.event', 'LIKE', '%' . $filter . '%')
                        ->orWhere('events.description', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])->rightjoin('event_steps','event_steps.id','step_fields.step_id')
        ->rightjoin('events','events.id','event_steps.event_id')
        ->orderBy('events.event', 'asc')->orderBy('event_steps.step_order', 'asc')->orderBy('step_fields.field_order', 'asc')
        ->paginate(5);

        $filter = $request->filter;
        $results->appends(['filter' => $filter]);

        return view('content.step_field.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'Tambah';
        $event_steps = EventStep::get();
        return view('content.step_field.form', compact('page','event_steps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'step_id' => 'required',
            'field_name'=> 'required',
            'field_description'=> 'required',
            'field_order'=> 'required',
            'field_type'=> 'required',
            'need_verif'=> 'required',
            'field_label' => 'required'
        ]);

        $input = $request->only(
            'step_id','field_name','field_description','field_order','field_type','allowed_type','default_value','model_referer','need_verif','is_required','field_label','options'
        );

        StepField::insert([
            $input
        ]);


        return to_route('step_field-index')->with(['success' => 'Data '.$input['field_name'].' telah berhasil disimpan!']);
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
        $result = StepField::find($id);
        $event_steps = EventStep::get();
        return view('content.step_field.form', compact('page', 'result','event_steps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'step_id' => 'required',
            'field_name'=> 'required',
            'field_description'=> 'required',
            'field_order'=> 'required',
            'field_type'=> 'required',
            'need_verif'=> 'required',
            'field_label' => 'required'
        ]);

        $input = $request->only(
            'step_id','field_name','field_description','field_order','field_type','allowed_type','default_value','model_referer','need_verif','is_required','field_label','options'
        );

        StepField::where('id',$id)->update(
            $input
        );

        return to_route('step_field-index')->with(['success' => 'Data '.$input['field_name'].' telah berhasil disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = StepField::find($id);
        if($result){
            StepField::destroy($id);
            return redirect()->route('step_field-index')->with(['success' => 'Data '.$result->field_name.' Berhasil Dihapus!']);
        }else{
            return redirect()->route('step_field-index')->with(['fail' => 'Data Tidak Ditemukan']);
        }
    }
}
