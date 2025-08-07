<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>@yield('title') | {{ config('app.name') }} </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    
    <!-- laravel CRUD token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/logos/favicon.ico') }}">

    @include('layouts/landing/styles')
  </head>

  <body>
    @yield('content')
    @include('layouts/landing/scripts')
  </body>

</html>