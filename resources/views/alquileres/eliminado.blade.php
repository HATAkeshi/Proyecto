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
                        <p style="font-weight: bold;">No hay Alquileres eliminados c:</p>
                    </div>
                </div>
            </div>
            @else
            <table class="table table-hover border-dark mt-2">
                <thead style="background-color: #9A3B3B;" class="text-light">
                    <tr>
                        <th style="display: none">ID</th>
                        <th>Fecha</th>
                        <th>Nombre de persona o empresa</th>
                        <th>Detalle</th>
                        <th>Modulos</th>
                        <th>Plataforma</th>
                        <th>Retraso de entrega</th>
                        <th>Nro de comprobante</th>
                        <th>Ingresos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrosEliminados as $alquilere)
                    <tr>
                        <td style="display: none">{{$alquilere->id}}</td>
                        <td>{{$alquilere->created_at->format('Y-m-d')}}</td>
                        <td>{{$alquilere->Nombre_de_persona_o_empresa}}</td>
                        <td>{{$alquilere->Detalle}}</td>
                        <td>{{$alquilere->Modulos}}</td>
                        <td>{{$alquilere->Plataforma}}</td>
                        <td>{{$alquilere->Retraso_de_entrega}}</td>
                        <td>{{$alquilere->Nro_de_comprobante}}</td>
                        <td>{{$alquilere->Ingresos}}</td>
                        <td>
                            <!-- Botón para restaurar -->
                            <form action="{{ route('alquileres.restore' , $alquilere->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                @can('restaurar-eliminados')
                                <button type="submit" class="btn text-light" style="background-color: #9A3B3B; font-weight: bold;">
                                    <i class="fas fa-undo"></i>
                                    Restaurar
                                </button>
                                @endcan
                            </form>
                        </td>
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