 {{-- resources/views/auth/verify-email.blade.php --}}
 
 @extends('layouts/blankLayout')
 
 @section('title', 'Verification Email Page')
 
 @section('content')
 <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
        <div class="d-flex align-items-center justify-content-center w-100">
            <div class="row justify-content-center w-100">
                <div class="col-md-8 col-lg-6 col-xxl-6">
                    <div class="alert alert-info" role="alert">
                        Link verifikasi baru telah dikirim ke alamat email Anda.
                    </div>
                    <div class="card">
                        <div class="card-header">{{ __('Verifikasi Alamat Email Anda') }}</div>
                        
                        <div class="card-body">
                            Sebelum melanjutkan anda perlu verifikasi email terlebih dahulu, silakan periksa email Anda untuk link verifikasi. Jika Anda tidak menerima email tersebut,
                            <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                                @csrf
                                <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('klik di sini untuk kirim ulang verifikasi email') }}</button>.
                            </form>
                            <br></br>
                            <form method="POST" action="{{ route('auth-logout') }}" id="logout-form">
                                @csrf
                                <input type="hidden" value="landing" name="page">
                                <a href="javascript:void(0);" onclick="document.getElementById('logout-form').submit();" >Kembali Ke Beranda</a>
                              </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
