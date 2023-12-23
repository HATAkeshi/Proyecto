@extends('adminlte::page')

@section('title', 'Ludeño|Alquiler')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Alquiler de Andamios</h2>
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
                                @can('crear-alquiler')
                                <a class="btn btn-warning mt-1" href="{{ route('alquileres.create') }}">
                                    <i class="fas fa-plus"></i>
                                    Nuevo
                                </a>
                                @endcan
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger mt-1">
                                    <i class="fas fa-print"></i>
                                    Imprimir
                                </button>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('alquileres.index') }}" method="GET" id="ordenarForm">
                                    <div class="row mb-3 align-items-center">
                                        <div class="col-auto">
                                            <select class="form-select mt-1" name="orden" id="ordenSelect">
                                                <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>Descendente</option>
                                                <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>Ascendente</option>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-success mt-1" type="submit" id="ordenarButtonFechaRango">
                                                <i class="fas fa-sort-alpha-down fa-lg"></i>
                                                Ordenar
                                            </button>
                                            <br>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('eliminados-alquilere') }}" type="button" class="btn btn-danger m-1">
                                    <i class="fas fa-eye"></i>
                                    Ver eliminados
                                </a>
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
                            <form method="GET" action="{{ route('alquileres.index') }}">
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

<!-- tabla de alquileres -->

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
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
                </thead>
                <tbody>
                    @foreach($alquileres as $alquilere)
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
                            <form class="deleteForm" action="{{ route('alquileres.destroy', $alquilere->id) }}" method="post">
                                @can('editar-alquiler')
                                <a href="{{ route('alquileres.edit', $alquilere->id) }}" class="btn btn-primary">
                                    <i class="fas fa-pen"></i>
                                    Editar
                                </a>
                                @endcan

                                @csrf
                                @method('DELETE')
                                @can('borrar-alquiler')
                                <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion('deleteForm')">
                                    <i class="fas fa-trash"></i>
                                    Borrar
                                </button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active">
                        <td colspan="7" style="text-align:right;">Total</td>
                        <td>{{ $sumaAlquileres }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- paginacion -->
<div class="pagination justify-content-end">
    {!! $alquileres->links() !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/tablasResposive.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('js/confirmarEliminacion.js') }}"></script>
<script src="{{ asset('js/FiltracionesOrdenamientoRangos.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop