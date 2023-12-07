@extends('adminlte::page')

@section('title', 'Ludeño|Depositos')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Depositos</h2>
    </div>
</div>
@stop

@section('content')

@can('crear-depositos')
<!-- <a class="btn btn-warning" href="{{ route('depositos.create') }}">Nuevo</a> -->
@endcan

<table class="table table-striped table-hover table-bordered mt-2">
    <thead class="table-dark">
        <th style="display: none">ID</th>
        <th>Nro de transaccion</th>
        <th>Nombre</th>
        <th>Monto</th>
    </thead>
    <tbody>
        @foreach($depositos as $deposito)
        <tr>
            <td style="display: none">{{$deposito->id}}</td>
            <td>{{$deposito->Nro_de_transaccion}}</td>
            <td>{{$deposito->Nombre}}</td>
            <td>{{$deposito->Monto}}</td>
            <td>
                <form action="{{ route('frm_depositos.destroy', $deposito->id) }}" method="post">
                    @can('editar-depositos')
                    <a href="{{ route('frm_depositos.edit', $deposito->id) }}" class="btn btn-primary">Editar</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('borrar-depositos')
                    <button type="submit" class="btn btn-danger">Borrar</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
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