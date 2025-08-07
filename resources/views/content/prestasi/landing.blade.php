@extends('layouts/landing/commonMaster' )
@section('title', 'Welcome')
@section('content')
    <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Navbar & Hero Start -->
        <div class="container-fluid header position-relative overflow-hidden p-0">
            <nav class="navbar navbar-expand-lg fixed-top navbar-light px-4 px-lg-5 py-3 py-lg-0">
                <a href="index.html" class="navbar-brand p-0">
                    <h1 class="display-6 text-primary m-0"></h1>
                    <!-- <img src="" alt="Logo"> -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav ms-auto py-0">
                        <a href="index.html" class="nav-item nav-link active">Beranda</a>
                    </div>
                    <a href="{{ route('auth') }}" class="btn btn-primary border border-primary rounded-pill text-primary py-2 px-4 me-4">Log In</a>
                    <a href="{{ route('sign-up') }}" class="btn btn-light rounded-pill text-white py-2 px-4">Daftar</a>
                </div>
            </nav>


            <!-- Hero Header Start -->
            <div class="hero-header overflow-hidden px-5">
                <div class="rotate-img">
                    <img src="{{ asset('mailer/img/sty-1.png') }}" class="img-fluid w-100" alt="">
                    <div class="rotate-sty-2"></div>
                </div>
                <div class="row gy-5 align-items-center">
                    <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                        <img src="{{ asset('images/logos/logo-app.png') }}" class="img-fluid w-50" alt="">
                        <h1 class="display-4 text-dark mb-4 wow fadeInUp" data-wow-delay="0.3s">Selamat Datang</h1>
                        <p class="fs-4 mb-4 wow fadeInUp" data-wow-delay="0.5s"></p>
                        <a href="#start" class="btn btn-primary rounded-pill py-3 px-5 wow fadeInUp" data-wow-delay="0.7s">Mulai</a>
                    </div>
                    <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                        <img src="{{ asset('mailer/img/hero-img-1.png') }}" class="img-fluid w-100 h-100" alt="">
                    </div>
                </div>
            </div>
            <!-- Hero Header End -->
        </div>
        <!-- Navbar & Hero End -->


        <!-- About Start -->
        <section id="start">
        <div class="container-fluid overflow-hidden py-5"  style="margin-top: 6rem;">
            <div class="container py-5">
                <div class="row g-5">
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="RotateMoveLeft">
                            <img src="{{ asset('mailer/img/about-1.png') }}" class="img-fluid w-100" alt="">
                        </div>
                    </div>
                    <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
                        <h4 class="mb-1 text-primary">Tentang Aplikasi</h4>
                        <h1 class="display-5 mb-4">SIKASHEVBERPRESTASI</h1>
                        <p class="mb-4">Layanan Surat Keterangan Penelitian Dan Praktek Kerja Lapangan Secara Online Yang Dikembangkan Oleh Bakesbangpol Untuk Memberikan Kemudahan Bagi Siswa/Mahasiswa Untuk Mencari Pengalaman Kerja Lapangan Dan Solusi Bagi Pemerintah Dalam Menyelesaikan Target Kinerja.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        </section>
        <!-- About End -->


        <!-- Feature Start -->
        <div class="container-fluid feature overflow-hidden py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h1 class="display-5 mb-4">Alur Pelayanan</h1>
                    </p>
                </div>
                <div class="row g-4 justify-content-center text-center mb-5">
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="text-center p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-sitemap fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Pemilihan Formasi <i class="fa fa-long-arrow-alt-right"></i></a>
                                <p class="mt-4 mb-0">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="text-center p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-mail-bulk fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Pendaftaran <i class="fa fa-long-arrow-alt-right"></i></a>
                                <p class="mt-4 mb-0">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="text-center rounded p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-tasks fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Verifikasi Berkas <i class="fa fa-long-arrow-alt-right"></i></a>
                                <p class="mt-4 mb-0">
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="text-center rounded p-4">
                            <div class="d-inline-block rounded bg-light p-4 mb-4"><i class="fas fa-envelope fa-5x text-secondary"></i></div>
                            <div class="feature-content">
                                <a href="#" class="h4">Penerbitan Surat Rekomendasi</a>
                                <p class="mt-4 mb-0">
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Feature End -->


        <!-- Service Start -->
        <div class="container-fluid service py-5">
            <div class="container py-5">
                <div class="text-center mx-auto mb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 900px;">
                    <h1 class="display-5 mb-4">Link Terkait</h1>
                    <p class="mb-0">
                    </p>
                </div>
                <div class="row g-4 justify-content-center">
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item text-center rounded p-4">
                            <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><img src="{{ asset('images/products/logo-satudatacimahi.png') }}" class="img-fluid w-100" alt=""></div>
                            <div class="service-content">
                                <h4 class="mb-4">Satu Data Kota Cimahi</h4>
                                <p class="mb-4">
                                </p>
                                <a href="https://satudata.cimahikota.go.id/" target="_blank" class="btn btn-light rounded-pill text-primary py-2 px-4">Buka</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="0.3s">
                        <div class="service-item text-center rounded p-4">
                            <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><img src="{{ asset('images/products/logo-piramidaciahi.png') }}" class="img-fluid w-100" alt=""></div>
                            <div class="service-content">
                                <h4 class="mb-4">Piramida</h4>
                                <p class="mb-4">
                                </p>
                                <a href="https://piramida.cimahikota.go.id/" target="_blank" class="btn btn-light rounded-pill text-primary py-2 px-4">Buka</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="0.5s">
                        <div class="service-item text-center rounded p-4">
                            <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><img src="{{ asset('images/products/logo-bps.webp') }}" class="img-fluid w-100" alt=""></div>
                            <div class="service-content">
                                <h4 class="mb-4">BPS Kota Cimahi</h4>
                                <p class="mb-4">
                                </p>
                                <a href="https://cimahikota.bps.go.id/id" target="_blank" class="btn btn-light rounded-pill text-primary py-2 px-4">Buka</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="0.7s">
                        <div class="service-item text-center rounded p-4">
                            <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><img src="{{ asset('images/products/logo-msib.png') }}" class="img-fluid w-100" alt=""></div>
                            <div class="service-content">
                                <h4 class="mb-4">MSIB Kemdikbud</h4>
                                <p class="mb-4">
                                </p>
                                <a href="https://kampusmerdeka.kemdikbud.go.id/" target="_blank"  class="btn btn-light rounded-pill text-primary py-2 px-4">Buka</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item text-center rounded p-4">
                            <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><img src="{{ asset('images/products/logo-kemdikbud.png') }}" class="img-fluid w-100" alt=""></div>
                            <div class="service-content">
                                <h4 class="mb-4">PTMGMRD Kemdikbud</h4>
                                <p class="mb-4">
                                </p>
                                <a href="https://lldikti4.kemdikbud.go.id/" target="_blank" class="btn btn-light rounded-pill text-primary py-2 px-4">Buka</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-4 wow fadeInUp" data-wow-delay="0.1s">
                        <div class="service-item text-center rounded p-4">
                            <div class="service-icon d-inline-block bg-light rounded p-4 mb-4"><img src="{{ asset('images/products/logo-cimahi.png') }}" class="img-fluid w-100" alt=""></div>
                            <div class="service-content">
                                <h4 class="mb-4">Prestasi</h4>
                                <p class="mb-4">
                                </p>
                                <a href="https://prestasi.appline.id/" target="_blank" class="btn btn-light rounded-pill text-primary py-2 px-4">Buka</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Service End -->


        <!-- Copyright Start -->
        <div class="container-fluid copyright py-4">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-6 text-center text-md-start mb-md-0">
                        <span class="text-white"><a href="#"><i class="fas fa-copyright text-light me-2"></i>SIKASHEVBERPRESTASI</a>, All right reserved.</span>
                    </div>
                    <div class="col-md-6 text-center text-md-end text-white">
                        <a class="border-bottom" href="https://htmlcodex.com">Badan Kesatuan Bangsa Dan Politik Kota Cimahi</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->


        <!-- Back to Top -->
        <a href="#" class="btn btn-primary btn-lg-square back-to-top"><i class="fa fa-arrow-up"></i></a>
@endsection