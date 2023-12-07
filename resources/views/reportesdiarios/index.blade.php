@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>Informe diario de caja</h2>
    </div>
</div>
@stop

@section('content')

<h3>DETALLE DE DOCUMENTOS RECEPCION DE INGRESOS</h3>
<hr>
<fieldset>
    <h4>Alquir de Andamios</h4>
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
    <!-- tabla de cursos -->
    <h4>Cursos</h4>
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
</fieldset>
<!-- las otras dos tablas  -->
<BR></BR>
<h3>DETALLE DE INGRESO DE EFECTIVO EN CAJA</h3>
<hr>
<fieldset>
    <h4>Depositos</h4>
    <table class="table table-striped table-hover table-bordered mt-2">
        <thead class="table-dark">
            <th style="display: none">ID</th>
            <th>Nro de transaccion</th>
            <th>Nombre</th>
            <th>Monto</th>
            <th>Acciones</th>
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
    <!-- tabla de gastios -->
    <h4>Gasto Extraordinario</h4>
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
        </tbody>
    </table>
</fieldset>

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