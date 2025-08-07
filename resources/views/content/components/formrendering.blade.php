<div class="card bg-primary text-white shadow-none position-relative overflow-hidden mb-4 fw-bold">
    <div class="card-body p-4" >
        <h4 class="text-white">{{ $headform->event }}</h4>
        <small class="text-white text-muted d-block mb-2 mt-0">
            {{ $headform->description }}
        </small>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="card-header bg-primary text-white fs-5 fw-bold">Tahapan</div>
    <div class="card-body p-4" style="overflow-x: auto;min-height:28vh;">
        @include('content.components.prosesstep', ['data' => $steps, 'step' => $step_id])
    </div>
</div>

@if(count($data_verif) > 0 && (Auth::User()->roles()->first()->name == $headform->step_owner || Auth::User()->roles()->first()->name == 'admin'))
    @include('content.components.verifrendering', ['data' => $data_verif])
@endif

@php
$progress = progressForm($headform->uniq_id);    
@endphp

@if(count($data) > 0)
<div class="card w-100 position-relative overflow-hidden">
    <div class="card-header bg-primary text-white fs-5 fw-bold">{{ $headform->event_step }}</div>
    <div class="card-body p-4 bg-light">
        <form id="formInput" enctype="multipart/form-data" action="{{ route('forminput-update',$headform->uniq_id) }}" method="POST">
            @csrf
            @method('PUT')
            @foreach($data as $key => $row)
                <div class="card-body p-4 border border-1 rounded-3 mb-2 bg-white">
                    @switch($row->field_type)
                    @case('textarea')
                        @include('content.components.textarea', ['attr' => $row, 'value' => getValue($headform->id, $row->step_id, $row->field_name), 'current_step' => $headform->current_step, 'status' => $progress->event->status])
                        @break
                    @case('select')
                        @include('content.components.selectinput', ['attr' => $row, 'value' => getValue($headform->id, $row->step_id, $row->field_name), 'current_step' => $headform->current_step, 'status' => $progress->event->status])
                        @break
                    @case('file')
                        @include('content.components.fileinput', ['attr' => $row, 'value' => getValue($headform->id, $row->step_id, $row->field_name), 'current_step' => $headform->current_step, 'status' => $progress->event->status])
                        @break
                    @default
                        @include('content.components.singleinput', ['attr' => $row, 'value' => getValue($headform->id, $row->step_id, $row->field_name), 'current_step' => $headform->current_step, 'status' => $progress->event->status])
                    @endswitch
                </div>
            @endforeach
            <div class="col mt-3 text-left float-end">
                @php
                    $progress = progressForm($headform->uniq_id);    
                @endphp
                @if($progress->event->current_step == $step_id && isOwnerStep($progress->event->current_step)==true && $headform->status == 'progress')
                    <button type="submit" class="btn btn-primary">Simpan</button>
                @endif
            </div>
        </form>
    </div>
</div>
@elseif(!Auth::User()->roles()->first()->name == 'admin')
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-header bg-primary text-white fs-5 fw-bold">KETERANGAN</div>
        <div class="card-body p-4">
            @php
                $progress = progressForm($headform->uniq_id);    
            @endphp
            {{ $progress->event->current_step == $step_id ? "Berkas Sedang Diproses." : ($progress->event->current_step > $step_id ? "Berkas Sudah Diproses." : "Berkas Sedang Diproses.") }}
        </div>
    </div>
@endif
<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4">
        <div class="row">
            <div class="col-12 d-flex mt-3 justify-content-between ">
                @if(prevStep($headform->event_id, $step_id) != null)
                    <a type="button" href="{{ route('forminput-submit', [$headform->uniq_id, prevStep($headform->event_id, $step_id)]) }}" class="btn btn-md btn-warning ms-2 d-inline-block" data-toggle="tooltip" data-placement="top" title="Prev" >Sebelumnya</a>
                @endif
                @php
                    $progress = progressForm($headform->uniq_id);    
                @endphp
                @if($progress->event->current_step == $step_id && isOwnerStep($progress->event->current_step)==true && $headform->status == 'progress')

                    @if(nextStep($headform->event_id, $step_id))    
                        <div>
                            <form id="formProcess" action="{{ route('forminput-process-step',$headform->uniq_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="current_step" value="{{nextStep($headform->event_id, $step_id)}}">
                            </form>
                            <a id="prosess_button" onclick="proses_button()" class="btn btn-md btn-primary ms-2 d-inline-block" data-toggle="tooltip" data-placement="top" title="Next">Proses Ke Tahap Selanjutnya <i class="ti ti-circle-chevron-right"></i></a>
                        </div>
                    
                    @endif

                    @if(Auth::User()->roles()->first()->name == 'admin')
                        
                            <form id="formFail" action="{{ route('forminput-finish-step',$headform->uniq_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="status" value="fail">
                            </form>
                            <a id="fail_button" onclick="fail_button()" class="btn btn-md btn-danger ms-2 d-inline-block" data-toggle="tooltip" data-placement="top" title="Next">TIDAK LOLOS VALIDASI<i class="ti ti-circle-chevron-right"></i></a>
                        
                        @if(!nextStep($headform->event_id, $step_id))
                            
                                <form id="formSuccess" action="{{ route('forminput-finish-step',$headform->uniq_id) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="status" value="success">
                                </form>
                                <a id="succes_button" onclick="finish_button()" class="btn btn-md btn-success ms-2 d-inline-block" data-toggle="tooltip" data-placement="top" title="Next">NYATAKAN LOLOS<i class="ti ti-circle-chevron-right"></i></a>

                                <a href="{{ route('forminput-export',['uniqid' => $headform->uniq_id]) }}" class="btn btn-md btn-primary ms-2 d-inline-block" data-toggle="tooltip" data-placement="top" title="Klik untuk mendownload draft surat">Download Draft Surat<i class="ti ti-circle-chevron-right"></i></a>
                            
                        @endif
                    @endif

                @else
                    @if(nextStep($headform->event_id, $step_id) != null && nextStep($headform->event_id, $step_id) <= $progress->event->current_step)
                        <a type="button" href="{{ route('forminput-submit', [$headform->uniq_id, nextStep($headform->event_id, $step_id)]) }}" class="btn btn-md btn-warning ms-2 d-inline-block" data-toggle="tooltip" data-placement="top" title="Next">Selanjutnya <i class="ti ti-circle-chevron-right"></i></a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@section('page-script')
    <script>
    $(document).on('change', '.uploadFile', function() {
        var objFormData = new FormData();
        var objFile = $(this)[0].files[0];
        var csrf = $('meta[name="csrf-token"]').attr('content');
        objFormData.append('_token', csrf)
        objFormData.append('field_name', $(this).attr('name'))
        objFormData.append($(this).attr('name'), objFile);
        const imageContainer = $("#result_"+$(this).attr('name'));
        imageContainer.html('<div class="d-inline-flex align-items-center text-start text-primary"><div class="spinner-border ms-auto me-2" role="status" aria-hidden="true"></div><strong>Mengunggah...</strong></div>')
        $.ajax({
            url: "<?=  route('forminput-store-files', $headform->uniq_id); ?>",
            type: 'POST',
            contentType: false,
            data: objFormData,
            //JQUERY CONVERT THE FILES ARRAYS INTO STRINGS.SO processData:false
            processData: false,
            success: function (response) {
                var url = response.data.file_url;
                imageContainer.html("<p class='mt-2 mb-0'><a target='_blank' href='"+response.data.file_url+"' >Lihat Lampiran</a></p>")
            },
            error: function (error) {
                alert(error.responseJSON.message)
                imageContainer.empty()
            }
        });
    });
    $(".formVerif").on('submit', function( event ) {
            event.preventDefault();
            $('#savebtn'+idelform).html('<div class="d-inline-flex align-items-center text-start text-primary"><div class="spinner-border ms-auto me-2" role="status" aria-hidden="true"></div><strong>...</strong></div>')
            const formData = new FormData(this);
            var idelform = $(this).attr('id')
            $('#reason'+idelform).removeClass('is-invalid')
            $('#message'+idelform).text('')
            if($('#isValid'+idelform).is(":checked")){
                $('#reason'+idelform).val('')
            }
            if(!$('#isValid'+idelform).is(":checked") && !$('#reason'+idelform).val()){
                $('#reason'+idelform).addClass('is-invalid')
                $('#message'+idelform).text('Kolom keterangan harus diisi.')
            }
            $.ajax({
                url: "<?=  route('forminput-store-verif', $headform->uniq_id); ?>",
                type: 'POST',
                data: formData,
                processData: false, // Important for FormData
                contentType: false, // Important for FormData
                success: function(response) {
                    console.log('Form submitted successfully:', response);
                    $('#savebtn'+idelform).html('<button type="submit" class="btn btn-primary">Simpan</button><i class="fs-6 text-success ti ti-circle-check"></i>')
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $('#savebtn'+idelform).html('<button type="submit" class="btn btn-primary">Simpan</button><i class="fs-6 text-danger ti ti-xbox-x"></i>')
                    console.error('Error submitting form:', textStatus, errorThrown);
                }
            });
        });
</script>
<script>
    function proses_button(){
        if (confirm('Apakah anda yakin semua data sudah benar dan akan memproses ke tahap selanjutnya?')){
            if (document.getElementById("formInput")) {
                if (document.getElementById("formInput").checkValidity()) {
                    // Form is valid, proceed with your logic
                    $('#formProcess').submit();
                } else {
                    // Form is invalid, handle accordingly
                    document.getElementById("formInput").reportValidity(); // This will trigger browser error messages
                }
            }else{
                $('#formProcess').submit();
            }
        }
    }

    function fail_button(){
        if (confirm('Apakah anda yakin terdapat data yang membuat usulan ini dinyatakan GAGAL?')){
                // Form is valid, proceed with your logic
                $('#formFail').submit();
        }
    }

    function finish_button(){
        if (confirm('Apakah anda yakin terdapat data valid dan usulan ini dinyatakan BERHASIL?')){
                // Form is valid, proceed with your logic
                $('#formSuccess').submit();
        }
    }
    </script>
@endsection
