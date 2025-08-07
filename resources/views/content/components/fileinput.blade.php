<div class="col-12 mb-3">
    <label class="form-label fs-4">{{ $attr->field_order }}. {{ $attr->field_label }} {{ $attr->is_required ? ' (wajib)' : ''}}</label>
    <small class="form-text text-warning d-block mb-2 mt-0 fst-italic">
        <i class="ti ti-info-circle"></i> {{ $attr->field_description }}
    </small>
    <input class="form-control uploadFile w-50" name="{{ $attr->field_name }}" id="{{ $attr->field_name }}" type="file" {{ $attr->is_required ? ((isset($value) && $value != null) ? '' : 'required') : ''}} {{ isOwnerStep($attr->step_id)==false || $current_step != $attr->step_id || $status != 'progress' ? ' disabled' : '' }}/>
    
    <div id="result_{{ $attr->field_name }}">
        @if(isset($value) && $value != null)
            <p class="mt-2 mb-0"><a target="_blank" href="{{ route('getfile', $value) }}" >Lihat Lampiran</a></p>
        @endif
    </div>
</div>