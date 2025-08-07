@extends('layouts/contentNavbarLayout')

@section('title', 'Users')

@section('content')
<div class="card card-body">
    <div class="row">
        <div class="col text-end d-flex justify-content-md-end">
            <a href="{{ route('role-index') }}" id="btn-add-contact" class="btn btn-info d-flex align-items-center me-2">
                <i class="ti ti-users text-white me-1 fs-5"></i> Role Management
            </a>
        </div>
    </div>
</div>

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">Data Users</h5>
    </div>
    <div class="card-body p-4">
        <div class="mb-4">
            <form action="" method="GET">
                <div class="row justify-content-end">
                    <div class="col-4 text-end">
                        <a href="{{ route('user-create') }}" type="button" class="btn btn-primary">Tambah</a>
                    </div>
                    <div class="col-8">
                        <div class="input-group input-group-merge">
                            <input type="text" name="filter" class="form-control" value="" placeholder="Search...">
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
            <table class="table border customize-table mb-0 align-middle">
                <thead class="text-dark fs-4">
                    <tr>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">No.</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Nama</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Username</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Email</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Role</h6>
                        </th>
                        <th>
                            <h6 class="fs-4 fw-semibold mb-0">Last Login</h6>
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
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ filter_var($row->profile->img_url, FILTER_VALIDATE_URL) ? $row->profile->img_url : route('getimage', $row->profile->img_url) }}" class="rounded-circle" width="40" height="40">

                                <div class="ms-3">
                                    <h6 class="fs-4 fw-semibold mb-0">{{ $row->name }}</h6>
                                </div>
                            </div>
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $row->username }}</h6>
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $row->email }}</h6>
                            
                                <span class="badge {{$row->email_verified_at ? 'bg-success-subtle text-success' : 'bg-warning-subtle text-warning'}} fw-semibold fs-2">{{ $row->email_verified_at ? 'Verified at '. date('d M Y H:i', strtotime($row->email_verified_at)) :  'Unverified' }}</span>
                        </td>
                        <td>
                            <p class="mb-0 fw-normal fs-4">{{ $row->roles->pluck('name')->implode(',') }}</p>
                        </td>
                        <td class="mb-0">
                            <h6 class="fw-bormal mb-0">{{ $row->last_login }}</h6>
                        </td>
                        <td>
                            <span class="badge {{$row->status == 'pending' ? 'bg-warning-subtle text-warning' : ($row->status == 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger')}} fw-semibold fs-2">{{ $row->status }}</span>
                        </td>
                        <td>
                            <div class="dropdown dropstart">
                                <a href="#" class="text-muted" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-dots-vertical fs-6"></i>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if (!$row->email_verified_at)
                                    <form id="form-{{$row->id}}" action="{{route('user-verifymanual',$row->id)}}" method="POST" onsubmit="return confirm('Apakah anda yakin akan verifikasi EMAIL {{$row->email}} secara manual?');">

                                        <input type="hidden" name="id" value="{{$row->id}}">

                                        @csrf
                                        @method('PUT')
                                        <button class="dropdown-item d-flex align-items-center gap-3" type="submit"><i class="fs-4 ti ti-check"></i>Verif Email</button>
                                    </form>
                                    @endif
                                    <li>
                                        <form id="formstatus-{{$row->id}}" action="{{route('user-changestatus',$row->id)}}" method="POST" onsubmit="return confirm('Apakah anda yakin akan mengubah data {{$row->username}} menjadi {{ $row->status == 'pending' ? 'active' : ($row->status == 'active' ? 'blocked' : 'active') }}?');">
                                            <input type="hidden" name="status" value="{{ $row->status == 'pending' ? 'active' : ($row->status == 'active' ? 'blocked' : 'active') }}">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="dropdown-item d-flex align-items-center gap-3"><i class="fs-4 ti ti-status-change"></i> Set {{ $row->status == 'pending' ? 'active' : ($row->status == 'active' ? 'blocked' : 'active') }}</button>
                                        </form>
                                    </li>
                                    
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('user-edit',['id' => $row->id]) }}"><i class="fs-4 ti ti-edit"></i>Edit</a>
                                    </li>
                                    
                                    @if ($row->status != 'active')
                                    <form id="form-{{$row->id}}" action="{{route('user-destroy',$row->id)}}" method="POST" onsubmit="return confirm('Apakah anda yakin akan menghapus data {{$row->name}}?');">

                                        <input type="hidden" name="id" value="{{$row->id}}">

                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item d-flex align-items-center gap-3" type="submit"><i class="fs-4 ti ti-trash"></i>Hapus</button>
                                    </form>
                                    @endif
                                    
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