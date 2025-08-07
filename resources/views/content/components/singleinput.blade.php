<div class="col-12 mb-3">
    <label class="form-label fs-4">{{ $attr->field_order }}. {{ $attr->field_label }} {{ $attr->is_required ? ' (wajib)' : ''}}</label>
    <small class="form-text text-warning d-block mb-2 mt-0 fst-italic">
        <i class="ti ti-info-circle"></i> {{ $attr->field_description }}
    </small>
    @php
    $d = $attr->default_value;
    if (strpos($d, "::") !== false || strpos($d, "->") !== false) {
        $d = eval('return ' . $d . ';');
    }
    @endphp
    <input type="{{ $attr->field_type }}" name="{{ $attr->field_name }}" id="{{ $attr->field_name }}" value="{{ old($attr->field_name) ?? ($value ? $value : $d) }}" class="@error('{{ $attr->field_name }}') is-invalid @enderror form-control" {{ $attr->is_required ? 'required' : ''}} {{ isOwnerStep($attr->step_id)==false || $current_step != $attr->step_id || $status != 'progress' ? ' disabled' : '' }}>
    @error('{{ $attr->field_name }}') <span class="text-danger">{{ $message }}</span> @enderror
</div>