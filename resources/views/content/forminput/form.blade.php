@extends('layouts/contentNavbarLayout')

@section('title', 'Formulir Usulan')

@section('content')
    @if($render == 'submit')
        @include('content.components.formrendering', ['data' => $data, 'data_verif' => $data_verif])
    @elseif($render == 'resume')
        @include('content.components.resumerendering', ['data' => $data])
    @endif
@endsection