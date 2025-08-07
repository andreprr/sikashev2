@extends('layouts/commonMaster' )

@section('layoutContent')
<!--  Body Wrapper -->
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
  @include('layouts/sections/menu/verticalMenu')
  <!--  Main wrapper -->
  <div class="body-wrapper">
    @include('layouts/sections/navbar/navbar')
    <div class="container-fluid" style="">
      @yield('content')
      @include('layouts/sections/footer/footer')
    </div>
  </div>
</div>
@endsection