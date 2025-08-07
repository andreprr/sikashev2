@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')

<div class="card card-body">
    <div class="row">
        <div class="col">
            <h6>Halo! {{ Auth::user()->name }}</h6>
            <p>Selamat Datang.</p>
        </div>
        @if ($success = Session::get('message'))
        <div class="alert alert-success" role="alert">
            {{ $success }}
        </div>
        @endif
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card border-0 bg-success-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Users</p>
                    <h5 class="fw-semibold text-success mb-0">{{ $user->user_active }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 bg-warning-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Tutor Meme</p>
                    <h5 class="fw-semibold text-success mb-0">{{ $user->user_tutors }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 bg-primary-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Member</p>
                    <h5 class="fw-semibold text-success mb-0">{{ $user->user_member }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 bg-danger-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Blocked</p>
                    <h5 class="fw-semibold text-success mb-0">{{ $user->user_blocked }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection