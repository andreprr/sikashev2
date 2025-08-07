<?php

namespace App\Http\Controllers\form;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Validation\Rule;
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = Event::where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query->orWhere('event', 'LIKE', '%' . $filter . '%')
                        ->orWhere('description', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])->orderBy('event', 'desc')
        ->paginate(5);

        $filter = $request->filter;
        $results->appends(['filter' => $filter]);

        return view('content.event.index', compact('results', 'filter'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page = 'Tambah';
        return view('content.event.form', compact('page'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'event' => 'required|unique:events|max:255',
            'description' => 'required'
        ]);

        $input = $request->only(
            'event',
            'description'
        );

        Event::insert([
            $input
        ]);


        return to_route('event-index')->with(['success' => 'Data '.$input['event'].' telah berhasil disimpan!']);
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
        $result = Event::find($id);
        return view('content.event.form', compact('page', 'result'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'event' => [
                'required',
                'max:255',
                Rule::unique('events')->ignore($id)
            ],
            'description' => 'required'
        ]);

        $input = $request->only(
            'event',
            'description'
        );

        Event::where('id',$id)->update(
            $input
        );

        return to_route('event-index')->with(['success' => 'Data '.$input['event'].' telah berhasil disimpan!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Event::find($id);
        if($result){
            Event::destroy($id);
            return redirect()->route('event-index')->with(['success' => 'Data '.$result->event.' Berhasil Dihapus!']);
        }else{
            return redirect()->route('event-index')->with(['fail' => 'Data Tidak Ditemukan']);
        }
    }
}
