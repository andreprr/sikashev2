<!DOCTYPE html>

<html class="light-style layout-menu-fixed" data-theme="theme-default" data-base-url="{{url('/')}}" data-template="modernize-bootstrap-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>@yield('title') | {{ config('app.name') }} </title>

  <!-- laravel CRUD token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicon -->
  <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logos/favicon.ico') }}">

  <!-- Include Styles -->
  @include('layouts/sections/styles')
  
  <!-- Include Scripts for customizer, helper, analytics, config -->
  @include('layouts/sections/scriptsIncludes')

  <style>
    .float{
	position:fixed;
	width:60px;
	height:60px;
	bottom:40px;
	right:40px;
	text-align:center;
  z-index:100;
}

.my-float{
	margin-top:16px;
}
</style>

</head>

<body>
  <!-- Layout Content -->
  @yield('layoutContent')
  <!--/ Layout Content -->

  <!-- Include Scripts -->
  @include('layouts/sections/scripts')
</body>

</html>