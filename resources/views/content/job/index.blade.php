@extends('layouts/contentNavbarLayout')

@section('title', 'Data Kebutuhan')

@section('content')

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Data Kebutuhan</h5>
    </div>
    <div class="card-body p-4">
        <div class="mb-4">
            <form action="" method="GET">
                <div class="row justify-content-end">
                    @if(Auth::User()->roles()->first()->name == 'admin' || Auth::User()->roles()->first()->name == 'opd')
                    <div class="col-4 text-end">
                        <a href="{{ route('job-create') }}" type="button" class="btn btn-primary">Tambah Data Kebutuhan</a>
                    </div>
                    @endif
                    <div class="col-8">
                        <div class="input-group input-group-merge">
                            <input type="text" name="filter" class="form-control" value="{{ $filter ?? null }}" placeholder="Search...">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        @if ($success = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $success }}
        </div>
        @endif
        <div class="table-responsive rounded-2 mb-4">
            <table class="table border customize-table mb-3 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No.</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Formasi</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Waktu Mulai</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Waktu Selesai</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Perangkat Daerah</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Deskripsi</h6>
                        </th>
                        @if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('admin'))
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>
                        @endif
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @if ($results->count() > 0)
                    @php
                    {{ $i=($results->perpage() * ($results->currentPage() -1)) + 1; }}
                    @endphp
                    @foreach ($results as $row)
                    <tr>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $i }}</h6>
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $row->job }}</h6>
                            @foreach($row->type as $value)
                            <span class="badge bg-info-subtle text-info fw-semibold fs-2 mt-2">{{ $value }}</span>
                            @endforeach
                            @foreach($row->study as $value)
                            <span class="badge bg-primary-subtle text-primary fw-semibold fs-2 mt-2">{{ $value }}</span>
                            @endforeach
                        </td>
                        <td class="mb-0 text-nowrap">
                            <h6 class="fw-bormal mb-0">{{ date("d-m-Y", strtotime($row->start_date)) }}</h6>
                        </td>
                        <td class="mb-0 text-nowrap">
                            <h6 class="fw-bormal mb-0">{{ date("d-m-Y", strtotime($row->end_date)) }}</h6>
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ strtoupper($row->opd) }}</h6>
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $row->description }}</h6>
                        </td>
                        @if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('admin'))
                        <td>
                            <span class="badge {{$row->status == 'draft' ? 'bg-warning-subtle text-warning' : ($row->status == 'publish' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger')}} fw-semibold fs-2">{{ $row->status }}</span>
                        </td>
                        @endif
                        <td>
                            @if(Auth::user()->hasRole('opd') || Auth::user()->hasRole('admin'))
                            <div class="dropdown dropstart">
                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <form id="formstatus-{{$row->id}}" action="{{route('job-changestatus',$row->id)}}" method="POST" onsubmit="return confirm('Apakah anda yakin akan mengubah data {{$row->job}} menjadi {{ $row->status == 'draft' ? 'publish' : 'draft' }}?');">
                                            <input type="hidden" name="status" value="{{ $row->status == 'draft' ? 'publish' : ($row->status == 'publish' ? 'finish' : 'draft') }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3"><i class="fs-4 ti ti-status-change"></i> Set {{ $row->status == 'draft' ? 'publish' : ($row->status == 'publish' ? 'finish' : 'draft') }}</button>
                                        </form>
                                    </li>
                                    @if($row->status == 'draft')
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('job-edit',['id' => $row->id]) }}"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    <form id="form-{{$row->id}}" action="{{route('job-destroy',$row->id)}}" method="POST" onsubmit="return confirm('Apakah anda yakin akan menghapus data {{$row->name}}?');">

                                        <input type="hidden" name="id" value="{{$row->id}}">

                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item d-flex align-items-center gap-3" type="submit"><i class="fs-4 ti ti-trash"></i>Hapus</button>
                                    </form>
                                    @endif
                                </ul>
                            </div>
                            @else
                                @if($row->status == 'publish')
                                    <form id="form-{{$row->id}}" action="{{route('forminput-store')}}" method="POST" onsubmit="return confirm('Apakah anda yakin akan mendaftar pada formasi {{$row->job}} pada {{$row->opd}} ?');">
                                        <input type="hidden" name="id" value="{{$row->id}}">
                                        @csrf
                                        <button class="btn btn-success" type="submit"><i class="fs-4 ti ti-submit"></i> Daftar</button>
                                    </form>
                                @endif
                            @endif
                        </td>
                    </tr>
                    @php
                    {{ $i++;}}
                    @endphp
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8" class="text-center">Data Kosong</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {{ $results->links() }}
        </div>
    </div>
</div>
@endsection
