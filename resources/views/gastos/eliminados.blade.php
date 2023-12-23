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
                        <p style="font-weight: bold;">No hay Gastos eliminados c:</p>
                    </div>
                </div>
            </div>
            @else
            <table class="table table-hover border-dark mt-2">
                <thead style="background-color: #9A3B3B;" class="text-light">
                    <tr>
                        <th style="display: none">ID</th>
                        <th>Fecha</th>
                        <th>Motivo resumido de salida de dinero</th>
                        <th>Nombre a quien se entrego el dinero</th>
                        <th>Quien aprobo la entrega de dinero</th>
                        <th>Nro de comprobante</th>
                        <th>Monto</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($registrosEliminados as $gasto)
                    <tr>
                        <td style="display: none">{{$gasto->id}}</td>
                        <td>{{$gasto->created_at->format('Y-m-d') }}</td>
                        <td>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</td>
                        <td>{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}</td>
                        <td>{{$gasto->Quien_aprobo_la_entrega_de_dinero}}</td>
                        <td>{{$gasto->Nro_de_comprobante}}</td>
                        <td>{{$gasto->Monto}}</td>
                        <td>
                            <!-- Botón para restaurar -->
                            <form action="{{ route('gastos.restore' , $gasto->id) }}" method="POST">
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