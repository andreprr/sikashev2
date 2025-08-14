<?php

namespace App\Http\Controllers\form;

use App\Http\Controllers\Controller;
use App\Models\EventStep;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\FormInput;
use App\Models\FormInputDetail; 
use App\Models\StepField;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Job;
use DateTime;

class FormInputController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $results = FormInput::select('events.*','form_inputs.submit_id','form_inputs.uniq_id','form_inputs.current_step','form_inputs.status','form_inputs.form_input_id_before','users.name','jobs.job','jobs.type','jobs.study','opd.name as opd_name')
        ->where([
            [function ($query) use ($request) {
                if (($filter = $request->filter)) {
                    $query
                    ->join('users', 'form_inputs.user_id', '=', 'users.id')
                    ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
                    ->leftjoin('events', 'form_inputs.event_id', '=', 'events.id')
                        ->orWhere('users.name', 'LIKE', '%' . $filter . '%')
                        ->orWhere('user_profiles.nip', 'LIKE', '%' . $filter . '%')
                        ->orWhere('events.event', 'LIKE', '%' . $filter . '%')
                        ->get();
                }
            }]
        ])
        ->join('users', 'form_inputs.user_id', '=', 'users.id')
        ->join('user_profiles', 'users.id', '=', 'user_profiles.user_id')
        ->join('jobs', 'jobs.id', '=', 'form_inputs.job_id')
        ->join('opd','opd.id','jobs.opd_id')
        ->leftjoin('events', 'form_inputs.event_id', '=', 'events.id')
        ->when(auth()->user()->hasRole('member'), function ($query) {
            $query->where('form_inputs.user_id',auth()->user()->id);
        })
        ->when(auth()->user()->hasRole('opd'), function ($query) {
            $query->where('opd.id',auth()->user()->opd->opd_id);
        })
        ->orderBy('form_inputs.current_step_at', 'desc')
        ->paginate(10);

        $filter = $request->filter;
        $results->appends(['filter' => $filter]);
        return view('content.forminput.index', compact('results','filter'));       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            //'event_id' => 'required|exists:events,id',
        ]);
        

        $uniq_id = md5(uniqid(mt_rand(), true));

        $cek = FormInput::selectRaw('count(*)')->where('user_id',auth()->user()->id)->whereDate('created_at', '=', date('Y-m-d'))->first();

        FormInput::create([
            'uniq_id' => $uniq_id,
            'event_id' => 1,
            'user_id' => auth()->user()->id,
            'submit_id' => "FSKPKL" . date('Ymd') . str_pad($cek->count + 1, 2, "0", STR_PAD_LEFT). str_pad(auth()->user()->id, 4, "0", STR_PAD_LEFT),
            'form_input_id_before' => $request->form_input_id ? $request->form_input_id : null,
            'job_id' => $request->id,
            'current_step' => 1,
            'current_step_at' => Carbon::now()->toDateTimeString()
        ]);

        return redirect()->route('forminput-submit', [$uniq_id,firstStepByEventId(1)]);
    }

    public function storeFiles(Request $request, $uniqid){
        $field = $request->field_name;
        if($request->$field){
            $data['file_url'] = $this->attachment_upload($request,$field,$uniqid);
            return jsend_success($data);
        }
    }

    public function storeVerif(Request $request, $uniqid){
        $isValid = $request->isValid;
        
        $request->validate([
            'form_input_detail_id' => 'required',
            'reason' => !$isValid ? 'required' : '',
        ]);

        FormInputDetail::where('id',$request->form_input_detail_id)->update([
            'isValid' => $isValid ? true : false,
            'reason' => $isValid ? '' : $request->reason,
            'valid_at' => Carbon::now()->toDateTimeString()
        ]);

        $data['message'] = "Data berhasil disimpan.";
        return jsend_success($data);
    }

    private function attachment_upload($request,$key,$key2){
        $request->validate([
            $key => 'required',
        ]);
        
        $fileName = $key.'_'.$key2.'.'.$request->$key->extension();
        $request->$key->move(storage_path('app/cloudfolder/files'), $fileName);

        //callhelper
        upsertForm($key2,$key,$fileName);

        return route('getfile',$fileName);
    }

    public function submit(string $uniqid, int $step_id = 1)
    {
        $data = StepField::where('step_id', $step_id)->orderBy('field_order','asc')->get();
        $headform = FormInput::select('form_inputs.*','events.event','events.description','event_steps.event_step','event_steps.step_owner')->where('uniq_id', $uniqid)->where('event_steps.id', $step_id)
        ->join('events', 'form_inputs.event_id', '=', 'events.id')
        ->join('event_steps', 'event_steps.event_id', '=', 'events.id')->first();
        $steps = EventStep::select('event_steps.*')->where('event_id', $headform->event_id)->orderBy('step_order')->get();
        $result = FormInputDetail::where('form_input_id', $headform->id)->where('step_id', $step_id)->orderby('field_order','asc')->get();
        $render = 'submit';

        $data_verif = [];
        $prev_id = prevStep($headform->event_id,$step_id);
        if($prev_id){
            $data_verif = FormInputDetail::where('form_input_id', $headform->id)->where('step_id', $prev_id)->where('need_verif', '1')->orderby('field_order','asc')->get();
        }
        //dd($data_verif);

        return view('content.forminput.form', compact('data','headform','steps','result','render','step_id','data_verif'));
    }

    public function processNextStep(Request $request, string $uid){
        $request->validate([
            'current_step' => 'required',
        ]);

        $input = $request->only(
            'current_step',
        );

        $input['current_step_at'] = Carbon::now()->toDateTimeString();
        $input['updated_at'] = Carbon::now()->toDateTimeString();

        FormInput::where('uniq_id',$uid)->update(
            $input
        );

        $head = FormInput::where('form_inputs.uniq_id', $uid)->first();

        $eventStep = EventStep::where('id', $head->current_step)->first();

        if($eventStep->owner != 'admin'){
            
        }


        return redirect()->route('forminput-submit', [$head->uniq_id, $input['current_step']]);


    }

    public function processFinishStep(Request $request, string $uid){
        $request->validate([
            'status' => 'required',
        ]);

        $input = $request->only(
            'status',
        );

        $input['current_step_at'] = Carbon::now()->toDateTimeString();
        $input['updated_at'] = Carbon::now()->toDateTimeString();

        FormInput::where('uniq_id',$uid)->update(
            $input
        );

        $head = FormInput::where('form_inputs.uniq_id', $uid)->first();
        return redirect()->route('forminput-submit', [$head->uniq_id, $head->current_step]);


    }

    public function resume(string $uniqid)
    {
        $data = FormInput::
            join('form_input_details', 'form_inputs.id', '=', 'form_input_details.form_input_id')
            ->select('form_input_details.*')
            ->where('uniq_id', $uniqid)->get();

        $steps = EventStep::select('event_steps.*')
        ->join('form_inputs', 'event_steps.event_id', '=', 'form_inputs.event_id')
        ->where('form_inputs.uniq_id', $uniqid)->get();
        $render = 'resume';

        return view('content.forminput.form', compact('data','steps','render'));
    }

    public function reset(string $uniqid)
    {
        $form = FormInput::where('uniq_id', $uniqid)->first();
        FormInput::where('uniq_id', $uniqid)->update([
            'current_step' => $form->current_step > 1 ? ($form->current_step - 1) : 1,
            'current_step_at' => Carbon::now()->toDateTimeString(),
        ]);

        return to_route('forminput-index')->with(['success' => 'Tahapan '.$form->submit_id.' telah berhasil direset!']);;
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $uid)
    {
        $head = FormInput::
        leftJoin('form_input_details', function($join)
            {
                $join->on('form_input_details.form_input_id', '=', 'form_inputs.id');
                $join->on('form_input_details.step_id', '=', 'form_inputs.current_step');
            }
        )
        ->where('form_inputs.uniq_id', $uid)
        ->select('form_inputs.*','form_input_details.id as form_input_detail_id')
        ->first();

        $field_data = StepField::where('step_id', $head->current_step)
            ->get();
        
        foreach ($field_data as $key => $value) {
            $field = $value->field_name;
            //callhelper
            if($value->field_type != 'file'){
                upsertForm($uid,$field,$request->$field);
            }
        }

        return redirect()->route('forminput-submit', [$head->uniq_id, $head->current_step]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function export(string $uniqid)
    {
        $data = FormInput::
            join('form_input_details', 'form_inputs.id', '=', 'form_input_details.form_input_id')
            ->join('jobs', 'jobs.id', '=', 'form_inputs.job_id')
            ->join('opd','opd.id','jobs.opd_id')
            ->select('form_input_details.*','opd.name as opd_name')
            ->where('uniq_id', $uniqid)->get();
            

        $result = [];
        foreach ($data as $key => $value) {
            $result[$value->field_name] = $value->value;
            if($value->model_referer){
                $model = getModelData($value->model_referer);                
            }
            $result['opd_name'] = $value->opd_name;
        }
        $result = (object)$result;

        setlocale(LC_TIME, 'id_ID.utf8');
        $day_mapping = [
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
            'Sunday'    => 'Minggu'
        ];
        $start_at = new DateTime($result->start_at);
        $english_day = strftime('%A', $start_at->getTimestamp());
        $indonesian_day = isset($day_mapping[$english_day]) ? $day_mapping[$english_day] : $english_day;
        
        $formatted_start_at = strftime('%A, %d %B %Y', $start_at->getTimestamp());
        $formatted_start_at = str_replace($english_day, $indonesian_day, $formatted_start_at);

        $finish_at = new DateTime($result->finish_at);
        $english_day = strftime('%A', $finish_at->getTimestamp());
        $indonesian_day = isset($day_mapping[$english_day]) ? $day_mapping[$english_day] : $english_day;
        
        $formatted_finish_at = strftime('%A, %d %B %Y', $finish_at->getTimestamp());
        $formatted_finish_at = str_replace($english_day, $indonesian_day, $formatted_finish_at);
        


        $templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor(app_path('Exports/Templates/suket_penelitian_khev.docx'));
        $templateProcessor->setValue(
            ['nomor_surat','institution', 'id_card_number', 'start_at','finish_at','name','applicant_job','opd_name'],
            [$result->nomor_surat ?? '',$result->institution ?? '', $result->id_card_number ?? '', $formatted_start_at ?? '', $formatted_finish_at ?? '', $result->name ?? '', $result->applicant_job ?? '', $result->opd_name ?? '']
        );

        $filename = 'draft_suketPKL_' . $uniqid . '.docx';
        $temp_file = tempnam(sys_get_temp_dir(), 'PHPWord');


        $templateProcessor->saveAs($temp_file);
        
        // Your browser will name the file "myFile.docx"
        // regardless of what it's named on the server 
        header("Content-Disposition: attachment; filename=" . $filename);

        readfile($temp_file); // or echo file_get_contents($temp_file);
        unlink($temp_file);  // remove temp file
    }
}
