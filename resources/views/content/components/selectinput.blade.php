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
    <select name="{{ $attr->field_name }}" id="{{ $attr->field_name }}" class="@error('{{ $attr->field_name }}') is-invalid @enderror form-control" {{ $attr->is_required ? 'required' : ''}} {{ isOwnerStep($attr->step_id)==false || $current_step != $attr->step_id || $status != 'progress' ? ' disabled' : '' }} >
        <option value="">Pilih {{ $attr->field_label }} ...</option>
        @if($attr->model_referer)
            @php $data = getModelData($attr->model_referer); @endphp
            @foreach($data as $row)
                @php $objkey = array_keys($row->toArray()); @endphp
                <option value="{{ $row->name }}"{{ $row->name == (old($attr->field_name) ?? ($value ? $value : $d)) ? 'selected' : '' }}>{{ $row[$objkey[1]] }}</option>
            @endforeach
        @else
            @php $data = $attr->options ? explode(';',$attr->options) : []; @endphp
            @if(count($data)>0)
                @foreach($data as $row)
                    @if($row)
                        <option value="{{ $row }}" {{ $row == (old($attr->field_name) ?? ($value ? $value : $d)) ? 'selected' : '' }}>{{ $row }}</option>
                    @endif
                @endforeach
            @endif
        @endif
    </select>
    @error('{{ $attr->field_name }}') <span class="text-danger">{{ $message }}</span> @enderror
</div>