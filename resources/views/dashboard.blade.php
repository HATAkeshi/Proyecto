@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<h1>Dashboard</h1>
@stop

@section('content')
<p>Welcome to this beautiful admin panel.</p>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
  console.log('Hola');
</script>
@stop