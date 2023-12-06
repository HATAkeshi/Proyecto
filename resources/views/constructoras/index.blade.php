@extends('adminlte::page')

@section('title', 'Ludeño|Constructora')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Constructora Ludeño</h2>
    </div>
</div>
@stop

@section('content')

@can('crear-constructora')
<a class="btn btn-warning" href="{{ route('constructoras.create') }}">Nuevo</a>
@endcan

<table class="table table-striped table-hover table-bordered mt-2">
    <thead class="table-dark">
        <th style="display: none">ID</th>
        <th>Dueño de la obra</th>
        <th>Direccion de la obra</th>
        <th>Fecha inicio de Obra</th>
        <th>Fecha fin de Obra</th>
        <th>Costo</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        @foreach($constructoras as $constructora)
        <tr>
            <td style="display: none">{{$constructora->id}}</td>
            <td>{{$constructora->Dueño_de_la_obra}}</td>
            <td>{{$constructora->Direccion_de_la_obra}}</td>
            <td>{{$constructora->Fecha_inicio_de_Obra}}</td>
            <td>{{$constructora->Fecha_fin_de_Obra}}</td>
            <td>{{$constructora->Costo}}</td>
            <td>
                <form action="{{ route('constructoras.destroy', $constructora->id) }}" method="post">
                    @can('editar-constructora')
                    <a href="{{ route('constructoras.edit', $constructora->id) }}" class="btn btn-primary">Editar</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('borrar-constructora')
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
    {!! $constructoras->links() !!}
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