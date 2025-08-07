<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4" >
       
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="card-body p-4">
            @foreach($data as $row)
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
            @endforeach
    </div>
</div>