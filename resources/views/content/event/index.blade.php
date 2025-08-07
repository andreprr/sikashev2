@extends('layouts/contentNavbarLayout')

@section('title', 'Events')

@section('content')

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Data Blueprint Event</h5>
    </div>
    <div class="card-body p-4">
        <div class="mb-4">
            <form action="" method="GET">
                <div class="row justify-content-end">
                    <div class="col-4 text-end">
                        <a href="{{ route('event-create') }}" type="button" class="btn btn-primary">Tambah</a>
                    </div>
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
                            <h6 class="fs-4 fw-semibold mb-0">Blueprint Event</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Deskripsi</h6>
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
                            <h6 class="fw-bormal mb-0">{{ $row->event }}</h6>
                        </td>
                        
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $row->description }}</h6>
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('event-edit',['id' => $row->id]) }}"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('event_step-index',['filter' => $row->event]) }}"><i class="fs-4 ti ti-menu"></i>Tahapan</a>
                                    </li>
                                    <form id="form-{{$row->id}}" action="{{route('event-destroy',$row->id)}}" method="POST" onsubmit="return confirm('Apakah anda yakin akan menghapus data {{$row->name}}?');">

                                        <input type="hidden" name="id" value="{{$row->id}}">

                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item d-flex align-items-center gap-3" type="submit"><i class="fs-4 ti ti-trash"></i>Hapus</button>
                                    </form>
                                </ul>
                            </div>
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