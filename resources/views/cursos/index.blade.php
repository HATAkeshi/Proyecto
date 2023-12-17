@extends('adminlte::page')

@section('title', 'Ludeño|Cursos')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Cursos en General</h2>
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
                                @can('crear-cursos')
                                <a class="btn btn-warning" href="{{ route('cursos.create') }}">
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
                            <form method="GET" action="{{ route('cursos.index') }}">
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
<!-- tabla de cursos -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Nombre de persona anticipo</th>
                    <th>Porcentaje de anticipo</th>
                    <th>Nombre de persona pago total</th>
                    <th>Detalle de curso</th>
                    <th>Numero de comprobante</th>
                    <th>Ingresos</th>
                    <th>Metodo de pago</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach($cursos as $curso)
                    <tr>
                        <td style="display: none">{{$curso->id}}</td>
                        <td>{{$curso->created_at->format('Y-m-d') }}</td>
                        <td>{{$curso->Nombre_de_persona}}</td>
                        <td>{{$curso->Porcentaje_de_anticipo}}</td>
                        <td>{{$curso->Nombre_de_persona_pago_total}}</td>
                        <td>{{$curso->Detalle_de_curso}}</td>
                        <td>{{$curso->Numero_de_comprobante}}</td>
                        <td>{{$curso->Ingresos}}</td>
                        <td>{{$curso->metodo_pago}}</td>
                        <td>
                            <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST">
                                @can('editar-cursos')
                                <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary">
                                    <i class="fas fa-pen"></i>
                                    Editar
                                </a>
                                @endcan

                                @csrf
                                @method('DELETE')
                                @can('borrar-cursos')
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
                        <td colspan="6" style="text-align:right;">Total</td>
                        <td>{{ $sumaCursos }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- paginacion -->
<div class="pagination justify-content-end">
    {!! $cursos->links() !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/tablasResposive.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop