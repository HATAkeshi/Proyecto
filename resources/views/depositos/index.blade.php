@extends('adminlte::page')

@section('title', 'Ludeño|Depositos')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Depositos</h2>
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
                                <!-- @can('crear-depositos')
                                <a class="btn btn-warning" href="{{ route('depositos.create') }}">
                                    <i class="fas fa-plus"></i>
                                    Nuevo
                                </a>
                                @endcan -->
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
                            <form method="GET" action="{{ route('depositos.index') }}">
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
<!-- tabla de depositos -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Nro de transaccion</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach($depositos as $deposito)
                    <tr>
                        <td style="display: none">{{$deposito->id}}</td>
                        <td>{{$deposito->created_at->format('Y-m-d') }}</td>
                        <td>{{$deposito->Nro_de_transaccion}}</td>
                        <td>{{$deposito->Nombre}}</td>
                        <td>{{$deposito->Monto}}</td>
                        <td>
                            @can('editar-depositos')
                            <a href="{{ route('depositos.edit', $deposito->id) }}" class="btn btn-primary">
                                <i class="fas fa-pen"></i>
                                Editar
                            </a>
                            @endcan
                            <!-- <form action="{{ route('depositos.destroy', $deposito->id) }}" method="post">
                                //aqui va el editar pero de momento ocuparemos solo el editar haci que no ocuparemos el formulario

                                @csrf
                                @method('DELETE')
                                @can('borrar-depositos')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>
                                    Borrar
                                </button>
                                @endcan
                            </form> -->
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td>{{ $sumaDepositos }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- paginacion -->
<div class="pagination justify-content-end">
    {!! $depositos->links() !!}
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