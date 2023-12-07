@extends('adminlte::page')

@section('title', 'Ludeño|Alquiler')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Alquiler de Andamios</h2>
    </div>
</div>
@stop

@section('content')

@can('crear-alquiler')
<a class="btn btn-warning" href="{{ route('alquileres.create') }}">Nuevo</a>
@endcan

<table class="table table-striped table-hover table-bordered mt-2">
    <thead class="table-dark">
        <th style="display: none">ID</th>
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
            <td>{{$alquilere->Nombre_de_persona_o_empresa}}</td>
            <td>{{$alquilere->Detalle}}</td>
            <td>{{$alquilere->Modulos}}</td>
            <td>{{$alquilere->Plataforma}}</td>
            <td>{{$alquilere->Retraso_de_entrega}}</td>
            <td>{{$alquilere->Nro_de_comprobante}}</td>
            <td>{{$alquilere->Ingresos}}</td>
            <td>
                <form action="{{ route('alquileres.destroy', $alquilere->id) }}" method="post">
                    @can('editar-alquiler')
                    <a href="{{ route('alquileres.edit', $alquilere->id) }}" class="btn btn-primary">Editar</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('borrar-alquiler')
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
    {!! $alquileres->links() !!}
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