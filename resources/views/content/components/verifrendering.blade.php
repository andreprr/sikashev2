<div class="card w-100 position-relative overflow-hidden">
    <div class="card-header bg-primary text-white fs-5 fw-bold">VERIFIKASI</div>
    <div class="card-body p-4 bg-light">
            @foreach($data as $row)
                <div class="card-body p-4 border border-1 rounded-3 mb-2 bg-white">
                    <form id="formVerif{{ $row->id }}" class="formVerif" enctype="multipart/form-data" action="{{ route('forminput-update',$headform->uniq_id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="form_input_detail_id" value="{{ $row->id }}">  
                        <div class="row">
                            <div class="col-4">
                            @switch($row->field_type)
                            @case('textarea')
                                <h5>{{ $row->field_label }}</h5>
                                <small class="form-text text-muted d-block mb-2 mt-0 bd-highlight">
                                    {{ $row->value }}
                                </small>
                                @break
                            @case('select')
                                <h5>{{ $row->field_label }}</h5>
                                <small class="form-text text-muted d-block mb-2 mt-0 bd-highlight">
                                    {{ $row->value }}
                                </small>
                                @break
                            @case('file')
                                <h5>{{ $row->field_label }}</h5>
                                <p class='mt-2 mb-3'><a target='_blank' href='{{ route('getfile', $row->value) }}' >Lihat Lampiran</a></p>
                                @break
                            @default
                                <h5>{{ $row->field_label }}</h5>
                                <small class="form-text text-muted d-block mb-2 mt-0 bd-highlight">
                                    {{ $row->value }}
                                </small>
                            @endswitch
                            </div>
                            <div class="col-2 border-start border-3">
                                <h5>Validasi Data</h5>
                                <small class="form-text text-muted d-block mb-2 mt-0 bd-highlight">
                                    Apabila valid, nyalakan tombol.
                                </small>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" name="isValid" type="checkbox" id="isValidformVerif{{ $row->id }}" {{ getVerif($row->id)->isValid ? 'checked' : '' }} {{ $headform->status != 'progress' ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="isValidformVerif{{ $row->id }}">Valid</label>
                                </div>
                            </div>
                            <div class="col-4 border-start border-3">
                                <h5>Keterangan</h5>
                                <small class="form-text text-muted d-block mb-2 mt-0 bd-highlight">
                                    Apabila tidak valid, tulis alasanya.
                                </small>
                                <textarea class="form-control" name="reason" id="reasonformVerif{{ $row->id }}" rows="3"  {{ $headform->status != 'progress' ? 'disabled' : '' }}>{{ getVerif($row->id)->reason }}</textarea>
                                <span class="text-danger" id="messageformVerif{{ $row->id }}"></span>
                            </div>
                            @if($headform->status == 'progress')    
                                <div class="col-2 border-start border-3 align-middle" id="savebtnformVerif{{ $row->id }}">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            @endif
                        </div>
                    </form>
                </div>
            @endforeach
    </div>
</div>