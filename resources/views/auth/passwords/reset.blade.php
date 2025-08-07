{{-- // resources/views/auth/passwords/reset.blade.php --}}

@extends('layouts/blankLayout')

@section('title', 'Reset Password Page')

@section('content')
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-3">
                    <div class="card mb-0">
                        <div class="card-body">
                            <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                <img class="shadow bg-primary rounded" src="{{ asset('images/logos/logo-app.png') }}" width="110" alt="{{ config('app.name') }}">
                            </a>
                            <p class="text-center">Reset Password Form</p>
                            
                            @if($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{$errors->first()}}
                            </div>
                            @endif
                            
                            @if(Session::has('status'))
                            <div class="alert alert-success" role="alert">
                                {{Session::get('status')}}
                            </div>
                            @endif
                            <form method="POST" action="{{ route('password.update') }}">
                                @csrf
                                
                                <input type="hidden" name="token" value="{{ $token }}">
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                                    
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <div class="input-group">
                                      <input type="password"  class="form-control @error('password') is-invalid @enderror" id="passwordField" name="password" aria-describedby="togglePassword" required autocomplete="new-password">
                                    </div>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="input-group">
                                      <input type="password"  class="form-control @error('password') is-invalid @enderror" id="password_confirmation" name="password_confirmation" aria-describedby="togglePassword" required autocomplete="new-password">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="captcha" class="form-label">ReCAPTCHA</label>
                                    <div class="input-group">
                                      @if (app()->environment('production'))
                                          {!! NoCaptcha::renderJs() !!}
                                          {!! NoCaptcha::display() !!}
                                      @endif
                                    </div>
                                  </div>
                                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Reset Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
