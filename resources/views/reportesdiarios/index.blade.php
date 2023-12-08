@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card">
    <div class="card-body">
        <h2>INFORME DIARIO DE CAJA</h2>
    </div>
</div>
@stop

@section('content')
<section class="container-fluid">
    <div class="col-lg-2 offset-lg-10">
        <div class="">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="text-align:right;">Saldo Inicial del dia:</th>
                    <td>{{ $restandoEgresos }}</td>
                </thead>
            </table>
        </div>
    </div>
</section>
<section class="container-fluid">
    <div class="col-lg-2 offset-lg-10">
        <div class="">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="text-align:right;">Saldo Final del dia:</th>
                    <td>{{ $restandoEgresos }}</td>
                </thead>
            </table>
        </div>
    </div>
</section>
<hr>
<h3>DETALLE DE DOCUMENTOS RECEPCION DE INGRESOS</h3>
<hr>
<section>
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
                <tr style="font-weight: bold;" class="table-active">
                    <td colspan="6" style="text-align:right;">Total</td>
                    <td>{{ $sumaAlquileresActual }}</td>
                </tr>
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
                <th>Metodo de Pago</th>
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
                    <td>{{$curso->metodo_pago}}</td>
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
                <tr style="font-weight: bold;" class="table-active">
                    <td colspan="5" style="text-align:right;">Total</td>
                    <td>{{ $sumaCursosActual }}</td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</section>
<section class="container-fluid">
    <div class="col-lg-12">
        <div class="">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="text-align:right;">TOTAL INGRESO</th>
                    <td>{{ $sumaCursosAlquileresActual }}</td>
                </thead>
            </table>
        </div>
    </div>
</section>
<!-- las otras dos tablas  -->
<BR></BR>
<h3>DETALLE DE INGRESO DE EFECTIVO EN CAJA</h3>
<hr>
<SECtion>
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
                        <form action="{{ route('depositos.destroy', $deposito->id) }}" method="post">
                            @can('editar-depositos')
                            <a href="{{ route('depositos.edit', $deposito->id) }}" class="btn btn-primary">Editar</a>
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
                <tr style="font-weight: bold;" class="table-active">
                    <td colspan="2" style="text-align:right;">Total</td>
                    <td>{{ $sumaDepositosActual }}</td>
                </tr>
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
                <tr style="font-weight: bold;" class="table-active">
                    <td colspan="4" style="text-align:right;">Total</td>
                    <td>{{ $sumaGastosActual }}</td>
                </tr>
            </tbody>
        </table>
    </fieldset>
</SECtion>
<section class="container-fluid">
    <div class="col-lg-12">
        <div class="">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="text-align:right;">TOTAL INGRESO EN EFECTIVO EN CAJA</th>
                    <td>{{ $sumaDepositosGastosActual }}</td>
                </thead>
            </table>
        </div>
    </div>
</section>

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