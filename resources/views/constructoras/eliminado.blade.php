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
                        <p style="font-weight: bold;">No hay construcciones eliminadas c:</p>
                    </div>
                </div>
            </div>
            @else
            <table class="table table-hover border-dark mt-2">
                <thead style="background-color: #9A3B3B;" class="text-light">
                    <tr>
                        <th style="display: none">ID</th>
                        <th>Fecha</th>
                        <th>Nro de comprobante</th>
                        <th>Dueño de la obra</th>
                        <th>Direccion de la obra</th>
                        <th>Fecha inicio de Obra</th>
                        <th>Fecha fin de Obra</th>
                        <th>Costo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrosEliminados as $constructora)
                    <tr>
                        <td style="display: none">{{$constructora->id}}</td>
                        <td>{{$constructora->created_at->format('Y-m-d')}}</td>
                        <td>{{$constructora->Nro_de_comprobante}}</td>
                        <td>{{$constructora->Dueño_de_la_obra}}</td>
                        <td>{{$constructora->Direccion_de_la_obra}}</td>
                        <td>{{$constructora->Fecha_inicio_de_Obra}}</td>
                        <td>{{$constructora->Fecha_fin_de_Obra}}</td>
                        <td>{{$constructora->Costo}}</td>
                        <td>
                            <!-- Botón para restaurar -->
                            <form action="{{ route('constructoras.restore', $constructora->id) }}" method="POST">
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