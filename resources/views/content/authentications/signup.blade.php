@extends('layouts/blankLayout')

@section('title', 'Login')

@section('content')

<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
    <div class="d-flex align-items-center justify-content-center w-100">
      <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6 col-xxl-3">
          <div class="card mb-0">
            <div class="card-body">
              <a href="" class="text-nowrap logo-img text-center d-block py-3 w-100">
                <img class="bg-white rounded" src="{{ asset('images/logos/logo-app.png') }}" width="110" alt="{{ config('app.name') }}">
              </a>
              <p class="text-center"><strong>SIKASHEVBERPRESTASI</strong></p>
              <p class="text-center">Isi formulir Berikut Sesuai Data Anda</p>
              
              @if($errors->any())
              <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
              </div>
              @endif

              @if(Session::has('message'))
              <div class="alert alert-success" role="alert">
                {{Session::get('message')}}
              </div>
              @endif
              
              <form action="{{ url('/auth/signup') }}" method="post">
                @csrf
                <div class="mb-3">
                  <label for="name" class="form-label">Nama Lengkap</label>
                  <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                </div>
                <div class="mb-4">
                  <label for="email" class="form-label">E-mail</label>
                  <div class="input-group">
                    <input type="email" class="form-control" id="emailField" name="email" value="{{old('email')}}" required>
                    <span class="input-group-text"><i class="ti ti-mail"></i></span>
                  </div>
                </div>
                <div class="mb-4">
                  <label for="email" class="form-label">No Handphone</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-phone"></i>+62</span>
                    <input type="number" class="form-control" id="phoneField" name="phone" value="{{old('phone')}}" required>
                  </div>
                </div>
                <div class="mb-4">
                  <label for="passwordField" class="form-label">Password (Minimal 8 Karakter)</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="passwordField" name="password" minlength="8" aria-describedby="togglePassword" required>
                    <span class="input-group-text"><i class="ti ti-eye" id="togglePassword"></i></span>
                  </div>
                </div>
                <div class="mb-4">
                  <label for="passwordConfirmationField" class="form-label">Ketik Ulang Password</label>
                  <div class="input-group">
                    <input type="password" class="form-control" id="passwordConfirmationField" name="password_confirmation"aria-describedby="togglePasswordConfirmation" required>
                    <span class="input-group-text"><i class="ti ti-eye" id="togglePasswordConfirmation"></i></span>
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
                <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Daftar Akun</button>
                <p class="text-center">Sudah punya Akun? Klik <a href="{{route('auth')}}">Login</a></p>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-script')
    <script>
        $(document).on("click", "#togglePassword", function() {
          const passwordField = document.getElementById('passwordField');
          const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordField.setAttribute('type', type);
          this.classList.toggle('ti-eye-off');
        });

        $(document).on("click", "#togglePasswordConfirmation", function() {
          const passwordField = document.getElementById('passwordConfirmationField');
          const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordField.setAttribute('type', type);
          this.classList.toggle('ti-eye-off');
        });
    </script>
@endsection