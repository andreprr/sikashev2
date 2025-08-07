<?php

namespace App\Http\Controllers\form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EventStep;
use App\Models\Event;
use Illuminate\Validation\Rule;
class EventStepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = EventStep::selectRaw('event_steps.*,events.event,events.description')->where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query->join('events','events.id','event_steps.event_id')
                        ->orWhere('event_steps.event_step', 'LIKE', '%' . $filter . '%')
                        ->orWhere('events.event', 'LIKE', '%' . $filter . '%')
                        ->orWhere('event_steps.step_description', 'LIKE', '%' . $filter . '%')
                        ->orWhere('event_steps.step_order', 'LIKE', '%' . $filter . '%')
                        ->orWhere('events.description', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])->join('events','events.id','event_steps.event_id')
        ->orderBy('events.event', 'asc')->orderBy('event_steps.step_order', 'asc')
        ->paginate(5);

        $filter = $request->filter;
        $results->appends(['filter' => $filter]);

        return view('content.event_step.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'Tambah';
        $events = Event::get();
        return view('content.event_step.form', compact('page','events'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_step' => 'required',
            'event_id' => 'required',
            'step_order' => 'required',
            'step_owner' => 'required',
            'step_description' => 'required'
        ]);

        $input = $request->only(
            'event_step',
            'event_id',
            'step_order',
            'step_owner',
            'step_description'
        );

        EventStep::insert([
            $input
        ]);


        return to_route('event_step-index')->with(['success' => 'Data '.$input['event_step'].' telah berhasil disimpan!']);
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
        $result = EventStep::find($id);
        $events = Event::get();
        return view('content.event_step.form', compact('page', 'result','events'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'event_step' => 'required',
            'event_id' => 'required',
            'step_order' => 'required',
            'step_owner' => 'required',
            'step_description' => 'required'
        ]);

        $input = $request->only(
            'event_step',
            'event_id',
            'step_order',
            'step_owner',
            'step_description'
        );

        EventStep::where('id',$id)->update(
            $input
        );

        return to_route('event_step-index')->with(['success' => 'Data '.$input['event_step'].' telah berhasil disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = EventStep::find($id);
        if($result){
            EventStep::destroy($id);
            return redirect()->route('event_step-index')->with(['success' => 'Data '.$result->event_step.' Berhasil Dihapus!']);
        }else{
            return redirect()->route('event_step-index')->with(['fail' => 'Data Tidak Ditemukan']);
        }
    }
}
