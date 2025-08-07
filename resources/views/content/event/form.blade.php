@extends('layouts/contentNavbarLayout')

@section('title', 'Event')

@section('content')

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $page }} Data Blueprint Event</h4>
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

<form enctype="multipart/form-data" action="{{ $page == 'Edit' ? route('event-update',$result->id) : route('event-store') }}" method="POST">
    @csrf
    @if($page == 'Edit')
    @method('PUT')
    @endif
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="event" class="form-label">Nama Event</label>
                    <input name="event" id="event" value="{{ old('event', $result->event ?? NULL) }}" class="@error('event') is-invalid @enderror form-control" required>
                    @error('event') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="description" class="form-label">Keterangan</label>
                    <input name="description" id="description" value="{{ old('description', $result->description ?? NULL) }}" class="@error('description') is-invalid @enderror form-control" required>
                    @error('description') <span class="text-danger">{{ $message }}</span> @enderror
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