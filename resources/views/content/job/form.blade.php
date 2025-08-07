@extends('layouts/contentNavbarLayout')

@section('title', 'Data Kebutuhan')

@section('content')

<div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
    <div class="card-body px-4 py-3">
        <div class="row align-items-center">
            <div class="col-9">
                <h4 class="fw-semibold mb-8">{{ $page }} Data Kebutuhan</h4>
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

<form enctype="multipart/form-data" action="{{ $page == 'Edit' ? route('job-update',$result->id) : route('job-store') }}" method="POST">
    @csrf
    @if($page == 'Edit')
    @method('PUT')
    @endif
    <div class="card w-100 position-relative overflow-hidden">
        <div class="card-body">
            <div class="row">
                <div class="col mb-3">
                    <label for="opd_id" class="form-label">Perangkat Daerah</label>
                    <select name="opd_id" id="opd_id" class="@error('opd_id') is-invalid @enderror form-control" required>
                        <option value="">Pilih Perangkat Daerah ...</option>
                        @foreach ($opds as $row)
                        <option value="{{ $row->id }}" {{ isset($result) ? ($result->opd_id == $row->id ? 'selected' : '') : '' }}>{{ $row->name }}</option>
                        @endforeach
                    </select>
                    @error('opd_id') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="job" class="form-label">Formasi</label>
                    <input name="job" id="job" value="{{ old('job', $result->job ?? NULL) }}" class="@error('job') is-invalid @enderror form-control" required>
                    @error('job') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="type" class="form-label">Jenjang Pendidikan</label>
                    <select name="type[]" id="type" class="form-control select-option" data-placeholder="Jenjang Pendidikan ..." style="height: 36px; width: 100%" multiple>
                        @php $opt = []; @endphp
                        @foreach($types as $row)
                            @foreach($row->type as $value)
                                @if(!in_array($value,$opt))
                                    <option value="{{ $value }}" {{ in_array($value,$result->type) ? 'selected' : '' }}>{{ $value }}</option>
                                    @php array_push($opt,$value); @endphp
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="study" class="form-label">Program Studi</label>
                    <select name="study[]" id="study" class="form-control select-option" data-placeholder="Program Studi ..." style="height: 36px; width: 100%" multiple>
                    @php $opt = []; @endphp
                        @foreach($studys as $row)
                            @foreach($row->study as $value)
                                @if(!in_array($value,$opt))
                                    <option value="{{ $value }}" {{ in_array($value,$result->study) ? 'selected' : '' }}>{{ $value }}</option>
                                    @php array_push($opt,$value); @endphp
                                @endif
                            @endforeach
                        @endforeach
                    </select>
                    @error('study') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
               <div class="col mb-3">
                    <label for="skill" class="form-label">Keahlian</label>
                    <input name="skill" id="skill" value="{{ old('skill', $result->skill ?? NULL) }}" class="@error('skill') is-invalid @enderror form-control" required>
                    @error('skill') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="requirement" class="form-label">Jumlah Kebutuhan</label>
                    <input name="requirement" type="number" id="requirement" value="{{ old('requirement', $result->requirement ?? NULL) }}" class="@error('requirement') is-invalid @enderror form-control" required>
                    @error('requirement') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="start_date" class="form-label">Waktu Mulai</label>
                    <input name="start_date" type="date" id="start_date" value="{{ old('start_date', $result->start_date ?? NULL) }}" class="@error('start_date') is-invalid @enderror form-control" required>
                    @error('start_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="col mb-3">
                    <label for="end_date" class="form-label">Waktu Selesai</label>
                    <input name="end_date" type="date" id="end_date" value="{{ old('end_date', $result->end_date ?? NULL) }}" class="@error('end_date') is-invalid @enderror form-control" required>
                    @error('end_date') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col mb-3">
                    <label for="description" class="form-label">Keterangan</label>
                    <textarea name="description" id="description" class="@error('description') is-invalid @enderror form-control">{{ old('description', $result->description ?? NULL) }}</textarea>
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
    $( document ).ready(function() {
        $(".select-option").select2({
            tags: true,
            tokenSeparators: [',']
        })
    });
</script>
@endsection
