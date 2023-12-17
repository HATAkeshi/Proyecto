@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Grafica de Ingresos Egresos por mes y año</h2>
    </div>
</div>
@stop

@section('content')

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