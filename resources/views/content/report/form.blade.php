@extends('layouts/contentNavbarLayout')

@section('title', 'Rooms')

@section('content')

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $page }} Report</h4>
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

<form enctype="multipart/form-data" action="{{ $page == 'Edit' ? route('report-update',$result->id) : route('report-store') }}" method="POST">
    @csrf
    @if($page == 'Edit')
    @method('PUT')
    @endif
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="name" class="form-label">Nama</label>
                    <input name="name" id="name" value="{{ old('name', $result->name ?? NULL) }}" class="@error('name') is-invalid @enderror form-control" required>
                    @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="room_id" class="form-label">Nama Room</label>
                    <select name="room_id" id="room_id" class="@error('room_id') is-invalid @enderror form-control" required>
                        <option value="">Pilih Nama Room ...</option>
                        @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" {{ isset($result) ? ($result->room_id == $room->id ? 'selected' : '') : '' }}>{{ $form->title }}</option>
                        @endforeach
                    </select>
                    @error('room_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea type="description" name="description" id="description" class="@error('description') is-invalid @enderror form-control">{{ old('description', $result->description ?? NULL) }}</textarea>
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

@section('page-script')
<script>
    var formjson = [];

    $( document ).ready(function() {
        $(".select-option").select2({
            tags: true,
            tokenSeparators: [',', ' ']
        })
    });
</script>
@endsection