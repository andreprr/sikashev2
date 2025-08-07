<?php

use Hamcrest\Arrays\IsArray;
?>
@extends('layouts/contentNavbarLayout')

@section('title', 'Role')

@section('content')

<div class="card w-100 position-relative overflow-hidden">
    <div class="px-4 py-3 border-bottom">
        <h5 class="card-title fw-semibold mb-0 lh-sm">{{ $page }} Role</h5>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert">
            {{ $message }}
        </div>
        @endif

        <form action="{{ $page == 'Edit' ? route('role-update',$result->id) : route('role-store') }}" method="POST">
            @csrf
            @if($page == 'Edit')
            @method('PUT')
            @endif
            <div class="mb-3">
                <label for="name" class="form-label">Nama Role</label>
                <input name="name" value="{{ $result->name ?? NULL }}" class="form-control">
            </div>
            <div class="mb-4">
                <label for="guard_name" class="form-label">Guard</label>
                <select name="guard_name" id="guard_name" class="form-control" required>
                    <option value="web">web</option>
                </select>
            </div>
            <hr>
            <div class="mb-3">
                <label for="guard_name" class="form-label">Permissions</label>
                @php
                    $arr = isset($result) ? json_decode(json_encode($result->permissions), true) : [];
                @endphp
                @foreach($permissions as $permission)
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="permission[]" value="{{ $permission->name }}" {{ (in_array($permission->name, array_column($arr, 'name'))) ? 'checked' : '' }}>
                    <label class="form-check-label" for="flexCheckDefault">
                        {{ $permission->name }}
                    </label>
                </div>
                @endforeach
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>
@endsection