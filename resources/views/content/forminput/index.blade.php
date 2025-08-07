@extends('layouts/contentNavbarLayout')

@section('title', 'Riwayat Usulan')

@section('content')

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Data Riwayat Usulan</h5>
    </div>
    <div class="card-body p-4">
        <div class="mb-4">
                <div class="row justify-content-end">
                    <div class="col-8">
                        <form action="" method="GET">
                        @csrf
                        <div class="input-group input-group-merge">
                            <input type="text" name="filter" class="form-control" value="{{ $filter ?? null }}" placeholder="Search...">
                            <button type="submit" class="btn btn-secondary">Filter</button>
                        </div>
                        </form>
                    </div>
                </div>
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
                            <h6 class="fs-4 fw-semibold mb-0">Nama Pemohon</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Formasi</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Progres</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                        </th>
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
                            <h6 class="fw-bormal mb-0">{{ $row->name }}</h6>
                            <small class="form-text text-muted d-block mb-0">{{ $row->submit_id }}</small>
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $row->job }}</h6>
                            @php $arr = json_decode($row->type); @endphp
                            @foreach($arr as $value)
                            <span class="badge bg-info-subtle text-info fw-semibold fs-2 mt-2">{{ $value }}</span>
                            @endforeach
                            @php $arr = json_decode($row->study); @endphp
                            @foreach($arr as $value)
                            <span class="badge bg-primary-subtle text-primary fw-semibold fs-2 mt-2">{{ $value }}</span>
                            @endforeach
                            <span class="badge bg-warning-subtle text-warning fw-semibold fs-2 mt-2 ms-1">{{ $row->opd_name }}</span>
                            
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0"> {{progressForm($row->uniq_id)->current_step->event_step}}
                            <h6 class="fw-bormal mb-0"> {{ progressForm($row->uniq_id)->step_inputed }} / {{ progressForm($row->uniq_id)->event->total_step }}</h6>
                        </td>
                        <td class="mb-0">
                            <span class="badge {{$row->status == 'success' ? 'bg-warning-subtle text-success' : ($row->status == 'fail' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary')}} fw-semibold fs-2">{{ $row->status }}</span>
                        </td>
                        <td>
                            @if($row->id)
                            <div class="dropdown dropstart">
                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('forminput-submit',['uniqid' => $row->uniq_id, 'step_id' => $row->current_step]) }}"><i class="fs-4 ti ti-edit"></i>Proses</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('forminput-resume',['uniqid' => $row->uniq_id]) }}"><i class="fs-4 ti ti-notes"></i>Ringkasan</a>
                                    </li>
                                    @if(Auth::user()->hasRole('admin')) 
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('forminput-reset',['uniqid' => $row->uniq_id]) }}"><i class="fs-4 ti ti-reload"></i>Reset</a>
                                    </li>
                                    @endif
                                    @if($row->status == 'success')
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('forminput-export',['uniqid' => $row->uniq_id]) }}"><i class="fs-4 ti ti-printer"></i>Download Surat Rekomendasi</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
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