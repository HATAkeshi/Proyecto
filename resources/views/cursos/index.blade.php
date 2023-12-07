@extends('adminlte::page')

@section('title', 'Ludeño|Cursos')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Cursos en General</h2>
    </div>
</div>
@stop

@section('content')

@can('crear-cursos')
<a class="btn btn-warning" href="{{ route('cursos.create') }}">Nuevo</a>
@endcan

<table class="table table-striped table-hover table-bordered mt-2">
    <thead class="table-dark">
        <th style="display: none">ID</th>
        <th>Nombre de persona anticipo</th>
        <th>Porcentaje de anticipo</th>
        <th>Nombre de persona pago total</th>
        <th>Detalle de curso</th>
        <th>Numero de comprobante</th>
        <th>Ingresos</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        @foreach($cursos as $curso)
        <tr>
            <td style="display: none">{{$curso->id}}</td>
            <td>{{$curso->Nombre_de_persona}}</td>
            <td>{{$curso->Porcentaje_de_anticipo}}</td>
            <td>{{$curso->Nombre_de_persona_pago_total}}</td>
            <td>{{$curso->Detalle_de_curso}}</td>
            <td>{{$curso->Numero_de_comprobante}}</td>
            <td>{{$curso->Ingresos}}</td>
            <td>
                <form action="{{ route('cursos.destroy', $curso->id) }}" method="POST">
                    @can('editar-cursos')
                    <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-primary">Editar</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('borrar-cursos')
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
    {!! $cursos->links() !!}
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