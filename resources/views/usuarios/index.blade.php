@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Usuarios</h2>
    </div>
</div>
@stop

@section('content')
<!-- botones de interaccion -->
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
                                @can('crear-usuarios')
                                <!-- crear -->
                                <a class="btn btn-warning" href="{{ route('usuarios.create') }}">
                                    <i class="fas fa-plus"></i> Nuevo</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- tabla de usuarios -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Nombre</th>
                    <th>E-mail</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </thead>
                <tbody>

                    @foreach($usuarios as $usuario)
                    <tr>
                        <td style="display: none">{{$usuario->id}}</td>
                        <td>{{$usuario->name}}</td>
                        <td>{{$usuario->email}}</td>
                        <td>
                            @if (!empty($usuario->getRoleNames()))
                            @foreach ($usuario->getRoleNames() as $rolName)
                            <h5><span class="badge badge-dark">{{$rolName}}</span></h5>
                            @endforeach
                            @endif
                        </td>
                        <td>
                            <form id="deleteForm" action="{{ route('usuarios.destroy', $usuario->id) }}" method="post">
                                @can('crear-usuarios')
                                <a class="btn btn-primary" href="{{ route('usuarios.edit', $usuario->id) }}">
                                    <i class="fas fa-pen"></i>
                                    Editar
                                </a>
                                @endcan

                                @csrf
                                @method('DELETE')
                                @can('borrar-usuarios')
                                <button type="submit" class="btn btn-danger" onclick="confirmarEliminacion('deleteForm')">
                                    <i class="fas fa-trash"></i>
                                    Borrar
                                </button>
                                @endcan
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
<div class="pagination justify-content-end">
    {!! $usuarios->links() !!}
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
<script>
    console.log('Hola');
</script>
@stop