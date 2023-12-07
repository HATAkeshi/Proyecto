@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Roles</h2>
    </div>
</div>
@stop

@section('content')

@can('crear-rol')
    <a href="{{ route('roles.create')}}" class="btn btn-warning">Nuevo</a>
@endcan

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
                    <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-primary">Editar</a>
                @endcan

                @can('borrar-rol')
                    {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id], 'style'=>'display:inline']) !!}
                        {!! Form::submit('Borrar', ['class'=>'btn btn-danger']) !!}
                    {!! Form::close() !!}
                @endcan
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

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