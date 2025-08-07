@extends('layouts/contentNavbarLayout')

@section('title', 'Step Fields')

@section('content')

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $page }} Data Blueprint Tahapan Field</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html">Index</a>
                        </li>
                        <li class="breadcrumb-item" aria-current="page">{{ $page }}</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>

<form enctype="multipart/form-data" action="{{ $page == 'Edit' ? route('step_field-update',$result->id) : route('step_field-store') }}" method="POST">
    @csrf
    @if($page == 'Edit')
    @method('PUT')
    @endif
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="step_id" class="form-label">Blueprint Event</label>
                    <select name="step_id" id="step_id" class="@error('step_id') is-invalid @enderror form-control" required>
                        <option value="">Pilih Step Event ...</option>
                        @foreach ($event_steps as $event)
                        <option value="{{ $event->id }}" {{ $event->id == (isset($result) ? $result->step_id : '') ? 'selected' : '' }}>{{ $event->event_step }}</option>
                        @endforeach
                    </select>
                    @error('step_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="field_label" class="form-label">Label</label>
                    <input name="field_label" id="field_label" value="{{ old('field_label', $result->field_label ?? NULL) }}" class="@error('field_label') is-invalid @enderror form-control" required>
                    @error('field_label') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="field_name" class="form-label">Nama Field</label>
                    <input name="field_name" id="field_name" value="{{ old('field_name', $result->field_name ?? NULL) }}" class="@error('field_name') is-invalid @enderror form-control" required>
                    @error('field_name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="type" class="form-label">Field Type</label>
                    <select name="field_type" id="field_type" class="@error('field_type') is-invalid @enderror form-control" required>
                        <option value="">Pilih Tipe ...</option>
                        @php
                            $types = ['file','text','textarea','select'];
                        @endphp
                        @foreach ($types as $type)
                        <option value="{{ $type }}" {{ $type == (isset($result) ? $result->field_type : '') ? 'selected' : '' }}>{{ strtoupper($type) }}</option>
                        @endforeach
                    </select>
                    @error('field_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col mb-3">
                    <label for="is_required" class="form-label">Is Required</label>
                    <input name="is_required" id="is_required" value="{{ old('is_required', $result->is_required ?? NULL) }}" class="@error('is_required') is-invalid @enderror form-control">
                    @error('is_required') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col mb-3">
                    <label for="need_verif" class="form-label">Need Verif</label>
                    <input name="need_verif" id="need_verif" value="{{ old('need_verif', $result->need_verif ?? NULL) }}" class="@error('need_verif') is-invalid @enderror form-control" required>
                    @error('need_verif') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="default_value" class="form-label">Default Value</label>
                    <input name="default_value" id="default_value" value="{{ old('default_value', $result->default_value ?? NULL) }}" class="@error('default_value') is-invalid @enderror form-control">
                    @error('default_value') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="options" class="form-label">Options Value</label>
                    <input name="options" id="options" value="{{ old('options', $result->options ?? NULL) }}" class="@error('options') is-invalid @enderror form-control">
                    @error('options') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="model_referer" class="form-label">Model Referer</label>
                    <input name="model_referer" id="model_referer" value="{{ old('model_referer', $result->model_referer ?? NULL) }}" class="@error('model_referer') is-invalid @enderror form-control">
                    @error('model_referer') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="type" class="form-label">Allowed Type</label>
                    <select name="allowed_type" id="allowed_type" class="@error('allowed_type') is-invalid @enderror form-control">
                        <option value="">Pilih Tipe ...</option>
                        @php
                            $types = ['png','jpg','pdf','any'];
                        @endphp
                        @foreach ($types as $type)
                        <option value="{{ $type }}" {{ $type == (isset($result) ? $result->allowed_type : '') ? 'selected' : '' }}>{{ strtoupper($type) }}</option>
                        @endforeach
                    </select>
                    @error('allowed_type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="field_order" class="form-label">Urutan</label>
                    <input type="number" name="field_order" id="field_order" value="{{ old('field_order', $result->field_order ?? NULL) }}" class="@error('field_order') is-invalid @enderror form-control" required>
                    @error('field_order') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

        

            <div class="row">
                <div class="col mb-3">
                    <label for="field_description" class="form-label">Keterangan</label>
                    <input name="field_description" id="field_description" value="{{ old('field_description', $result->field_description ?? NULL) }}" class="@error('field_description') is-invalid @enderror form-control" required>
                    @error('field_description') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection