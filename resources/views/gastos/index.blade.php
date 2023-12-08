@extends('adminlte::page')

@section('title', 'Ludeño|Gastos')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Gasto Extraordinario</h2>
    </div>
</div>
@stop

@section('content')

@can('crear-gastos')
<a class="btn btn-warning" href="{{ route('gastos.create') }}">Nuevo</a>
@endcan

<table class="table table-striped table-hover table-bordered mt-2">
    <thead class="table-dark">
        <th style="display: none">ID</th>
        <th>Motivo resumido de salida de dinero</th>
        <th>Nombre a quien se entrego el dinero</th>
        <th>Quien aprobo la entrega de dinero</th>
        <th>Nro de comprobante</th>
        <th>Monto</th>
        <th>Acciones</th>
    </thead>
    <tbody>
        @foreach($gastos as $gasto)
        <tr>
            <td style="display: none">{{$gasto->id}}</td>
            <td>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</td>
            <td>{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}</td>
            <td>{{$gasto->Quien_aprobo_la_entrega_de_dinero}}</td>
            <td>{{$gasto->Nro_de_comprobante}}</td>
            <td>{{$gasto->Monto}}</td>
            <td>
                <form action="{{ route('gastos.destroy', $gasto->id) }}" method="post">
                    @can('editar-gastos')
                    <a href="{{ route('gastos.edit', $gasto->id) }}" class="btn btn-primary">Editar</a>
                    @endcan

                    @csrf
                    @method('DELETE')
                    @can('borrar-gastos')
                    <button type="submit" class="btn btn-danger">Borrar</button>
                    @endcan
                </form>
            </td>
        </tr>
        @endforeach
        <tr style="font-weight: bold;" class="table-active">
            <td colspan="4" style="text-align:right;">Total</td>
            <td>{{ $sumaGastos }}</td>
        </tr>
    </tbody>
</table>
<!-- paginacion -->
<div class="pagination justify-content-end">
    {!! $gastos->links() !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop