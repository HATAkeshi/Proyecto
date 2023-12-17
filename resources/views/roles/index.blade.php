@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Roles</h2>
    </div>
</div>
@stop

@section('content')

<!-- botones de interaccion-->
<section class="container-fluid mt-4">
    <div class="row justify-content-start">
        <!-- botones de interccion -->
        <div class="col-md-3">
            <div class="card shadow h-100 d-flex">
                <div class="card-body bg-dark shadow-xl">
                    <div class="card-title">
                        <p style="font-weight: bold;">Botones de Interaccion</p>
                        <hr>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-auto">
                                @can('crear-rol')
                                <a href="{{ route('roles.create')}}" class="btn btn-warning">
                                    <i class="fas fa-plus"></i>
                                    Nuevo
                                </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- tabla de roles -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th>Rol</th>
                    <th>Acciones</th>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>
                            @can('editar-rol')
                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">
                                <i class="fas fa-pen"></i>
                                Editar
                            </a>
                            @endcan

                            @can('borrar-rol')
                            {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id], 'style'=>'display:inline']) !!}
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i>
                                Borrar
                            </button>
                            {!! Form::close() !!}
                            @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- centramos nuestra paginacion a la derecha -->
<div class="pagination justify-content-end">
    {!! $roles->links() !!}
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