@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard')

@section('content')

<link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-1/assets/css/timeline-1.css">

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

{{-- <div class="row">
    <div class="col">
        <div class="card border-0 bg-success-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Total Pelatihan</p>
                    <h5 class="fw-semibold text-success mb-0">{{ $coursemember->course_total }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 bg-warning-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Progress Pelatihan </p>
                    <h5 class="fw-semibold text-success mb-0">{{ $coursemember->course_progress }}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="col">
        <div class="card border-0 bg-primary-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Jumlah Sertifikat</p>
                    <h5 class="fw-semibold text-success mb-0">{{ $coursemember->course_success }}</h5>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="col">
        <div class="card border-0 bg-danger-subtle shadow-none">
            <div class="card-body">
                <div class="text-center">
                    <p class="fw-semibold fs-3 text-success mb-1">Pelatihan gagal </p>
                    <h5 class="fw-semibold text-success mb-0">{{ $coursemember->course_fail }}</h5>
                </div>
            </div>
        </div>
    </div> 
</div> --}}

{{-- <!-- Timeline 1 - Bootstrap Brain Component -->
<section class="bsb-timeline-1 py-5 py-xl-8">
    <div class="container">
        <!-- Timeline -->
        @if ($history->count() == 0)
        <h2 class="text-center mb-4">Tidak ada timeline riwayat pelatihan</h2>
        @else
        <h2 class="text-center mb-4">Timeline Riwayat pelatihan</h2>
        @endif
        <div class="row justify-content-left">
            <div class="col-10 col-md-8 col-xl-6">
                <ul class="timeline">
                    @foreach ($history as $row)
                        <li class="timeline-item">
                            <div class="timeline-body">
                                <div class="timeline-content">
                                    <div class="card border-0">
                                        <div class="card-body p-2">
                                            <h5 class="card-subtitle text-secondary mb-1">{{ date('d F Y, H:i', strtotime($row->created_at)) }}</h5>
                                            <h2 class="card-title mb-1">Anda Mengikuti Pelatihan {{ $row->title }}</h2>
                                            <p class="card-text m-2">dari {{ $row->organization }} <span class="badge bg-{{ in_array($row->status, ['accept', 'finish']) ? 'warning' : ($row->status == 'success' ? 'success' : 'danger') }}">{{ in_array($row->status, ['accept', 'finish']) ? 'berlangsung' : ($row->status == 'success' ? 'selesai' : 'gagal') }}</span></p>

                                            @if (in_array($row->status, ['success']))
                                                <p class="card-text m-2">Selesai pada <span class="badge bg-info">{{ date('d F Y, H:i', strtotime($row->completed_at)) }}</span></p>
                                                <a class="btn btn-success" target="_blank" href="{{ route('certificate', ['token' => $row->token])}}"><i class="fs-4 ti ti-eyes"></i> Lihat Sertifikat</a>
                                            @elseif (in_array($row->status, ['accept', 'finish']))
                                                <a href="{{ route('app-detail-course', ['slug' => $row->slug]) }}" class="btn btn-primary"><i class="fs-4 ti ti-book"></i>Lihat Pelatihan</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section> --}}

@endsection