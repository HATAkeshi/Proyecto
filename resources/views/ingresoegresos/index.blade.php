@extends('adminlte::page')

@section('title', 'Ludeño|Ingresos Egresos')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Informes de Ingresos Egresos</h2>
    </div>
</div>
@stop

@section('content')

<section>
    <table class="table table-striped table-hover table-bordered mt-2">
        <thead class="table-dark">
            <th style="display: none">ID</th>
            <th>Fecha</th>
            <th>Detalle</th>
            <th>Nombre</th>
            <th>Ingreso</th>
            <th>Egreso</th>
            <th>Saldo</th>
        </thead>
        <tbody>
            @foreach($ingresoegresos as $ingresoegreso)
            <tr>
                <td style="display: none">{{$ingresoegreso->id}}</td>
                <td>{{$ingresoegreso->fecha}}</td>
                <td>{{$ingresoegreso->Detalle}}</td>
                <td>{{$ingresoegreso->Nombre}}</td>
                <td>{{$ingresoegreso->Ingreso}}</td>
                <td>{{$ingresoegreso->Egreso}}</td>
                <td>{{$ingresoegreso->Saldo}}</td>
            </tr>
            @endforeach
            <tr style="font-weight: bold;" class="table-active">
                <td colspan="5" style="text-align:right;">Total</td>
                <td></td>
            </tr>
        </tbody>
    </table>
</section>
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