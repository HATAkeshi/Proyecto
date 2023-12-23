@extends('adminlte::page')

@section('title', 'Ludeño|Eliminados')

@section('content_header')
<div class="text-white" style="background-color: #000000;">
    <div class="card-body">
        <h2><i class="fas fa-trash"></i> Eliminados </h2>
    </div>
</div>
@stop

@section('content')
<section class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            @if($registrosEliminados->isEmpty())
            <div class="row align-items-center">
                <div class="card bg-success">
                    <div class="card-body">
                        <p style="font-weight: bold;">No hay Depositos eliminados c:</p>
                    </div>
                </div>
            </div>
            @else
            <table class="table table-hover border-dark mt-2">
                <thead style="background-color: #9A3B3B;" class="text-light">
                    <tr>
                        <th style="display: none">ID</th>
                        <th>Fecha</th>
                        <th>Nro de transaccion</th>
                        <th>Nombre</th>
                        <th>Monto</th>
                        <!-- <th>Acciones</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrosEliminados as $deposito)
                    <tr>
                        <td style="display: none">{{$deposito->id}}</td>
                        <td>{{$deposito->created_at->format('Y-m-d') }}</td>
                        <td>{{$deposito->Nro_de_transaccion}}</td>
                        <td>{{$deposito->Nombre}}</td>
                        <td>{{$deposito->Monto}}</td>
                        <!-- agragar boton de restaurado si es nesesario -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
</section>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/tablasResposive.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop