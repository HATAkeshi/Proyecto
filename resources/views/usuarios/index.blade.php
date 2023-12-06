@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Usuarios</h2>
    </div>
</div>
@stop

@section('content')

@can('crear-usuarios')
    <!-- crear -->
    <a class="btn btn-warning" href="{{ route('usuarios.create') }}">Nuevo</a>
@endcan
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
                @can('crear-usuarios')
                <a class="btn btn-info" href="{{ route('usuarios.edit', $usuario->id) }}">Editar</a>
                @endcan
                @can('borar-usuarios')
                {!! Form::open(['method'=> 'DELETE', 'route'=> ['usuarios.destroy', $usuario->id], 'style'=>'display:inline']) !!}
                    {!! Form::submit('Borrar', ['class'=> 'btn btn-danger']) !!}
                {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="pagination justify-content-end">
    {!! $usuarios->links() !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hola');
</script>
@stop