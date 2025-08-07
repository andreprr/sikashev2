@extends('layouts/contentNavbarLayout')

@section('title', 'Event Steps')

@section('content')

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $page }} Data Blueprint Tahapan Event</h4>
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

<form enctype="multipart/form-data" action="{{ $page == 'Edit' ? route('event_step-update',$result->id) : route('event_step-store') }}" method="POST">
    @csrf
    @if($page == 'Edit')
    @method('PUT')
    @endif
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="event_id" class="form-label">Blueprint Event</label>
                    <select name="event_id" id="event_id" class="@error('event_id') is-invalid @enderror form-control" required>
                        <option value="">Pilih Event ...</option>
                        @foreach ($events as $event)
                        <option value="{{ $event->id }}" {{ $event->id == (isset($result) ? $result->event_id : '') ? 'selected' : '' }}>{{ $event->event }}</option>
                        @endforeach
                    </select>
                    @error('event_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="event_step" class="form-label">Nama Tahapan</label>
                    <input name="event_step" id="event_step" value="{{ old('event_step', $result->event_step ?? NULL) }}" class="@error('event_step') is-invalid @enderror form-control" required>
                    @error('event_step') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="step_owner" class="form-label">Pemilik Tahapan</label>
                    <input name="step_owner" id="step_owner" value="{{ old('step_owner', $result->step_owner ?? NULL) }}" class="@error('step_owner') is-invalid @enderror form-control" required>
                    @error('step_owner') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            
            <div class="row">
                <div class="col-12 mb-3">
                    <label for="step_order" class="form-label">Urutan</label>
                    <input type="number" name="step_order" id="step_order" value="{{ old('step_order', $result->step_order ?? NULL) }}" class="@error('step_order') is-invalid @enderror form-control" required>
                    @error('step_order') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="row">
                <div class="col mb-3">
                    <label for="step_description" class="form-label">Keterangan</label>
                    <input name="step_description" id="step_description" value="{{ old('step_description', $result->step_description ?? NULL) }}" class="@error('step_description') is-invalid @enderror form-control" required>
                    @error('step_description') <span class="text-danger">{{ $message }}</span> @enderror
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