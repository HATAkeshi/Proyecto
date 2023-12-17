@extends('adminlte::page')

@section('title', 'Ludeño|Gastos')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Gasto Extraordinario</h2>
    </div>
</div>
@stop

@section('content')

<!-- filtrador por fecha y los botones de interaccion-->
<section class="container-fluid mt-4">
    <div class="row justify-content-start">
        <!-- botones de interccion -->
        <div class="col-md-4">
            <div class="card shadow h-100 d-flex">
                <div class="card-body bg-dark shadow-xl">
                    <div class="card-title">
                        <p style="font-weight: bold;">Botones de Interaccion</p>
                        <hr>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-auto">
                                @can('crear-gastos')
                                <a class="btn btn-warning" href="{{ route('gastos.create') }}">
                                    <i class="fas fa-plus"></i>
                                    Nuevo
                                </a>
                                @endcan
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-print"></i>
                                    Imprimir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- busqueda por fecha -->
        <div class="col-md-4">
            <div class="card shadow h-100 d-flex">
                <div class="card-body bg-dark shadow-xl">
                    <div class="card-title">
                        <p style="font-weight: bold;">Busqueda por fecha</p>
                        <hr>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <form method="GET" action="{{ route('gastos.index') }}">
                                @csrf
                                <div class="row mb-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="fecha_inicio">Fecha Inicial:</label>
                                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <label for="fecha_inicio">Fecha Final:</label>
                                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                                    </div>
                                    <div class="col-auto mt-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                            Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- tabla de gastos -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Motivo resumido de salida de dinero</th>
                    <th>Nombre a quien se entrego el dinero</th>
                    <th>Quien aprobo la entrega de dinero</th>
                    <th>Nro de comprobante</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach($gastos as $gasto)
                    <tr>
                        <td style="display: none">{{$gasto->id}}</td>
                        <td>{{$gasto->created_at->format('Y-m-d') }}</td>
                        <td>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</td>
                        <td>{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}</td>
                        <td>{{$gasto->Quien_aprobo_la_entrega_de_dinero}}</td>
                        <td>{{$gasto->Nro_de_comprobante}}</td>
                        <td>{{$gasto->Monto}}</td>
                        <td>
                            <form action="{{ route('gastos.destroy', $gasto->id) }}" method="post">
                                @can('editar-gastos')
                                <a href="{{ route('gastos.edit', $gasto->id) }}" class="btn btn-primary">
                                    <i class="fas fa-pen"></i>
                                    Editar
                                </a>
                                @endcan

                                @csrf
                                @method('DELETE')
                                @can('borrar-gastos')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                    Borrar
                                </button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active">
                        <td colspan="5" style="text-align:right;">Total</td>
                        <td>{{ $sumaGastos }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- paginacion -->
<div class="pagination justify-content-end">
    {!! $gastos->links() !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/tablasResposive.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop