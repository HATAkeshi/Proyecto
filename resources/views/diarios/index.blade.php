@extends('adminlte::page')

@section('title', 'Ludeño')

@section('content_header')
<div class="card bg-dark text-white text-center">
    <div class="card-body">
        <h2>INFORME DIARIO DE CAJA</h2>
    </div>
</div>
@stop

@section('content')

<!-- filtrador por fecha y los botones de interaccion-->
<section class="container-fluid mt-4">
    <div class="row ">
        <div class="col-md-4">
            <div class="card shadow h-100 d-flex">
                <div class="card-body bg-dark shadow-xl">
                    <div class="card-title">
                        <p>Busqueda por fecha</p>
                        <hr>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <form method="GET" action="{{ route('diarios.index') }}">
                                @csrf
                                <div class="row mb-3 align-items-center">
                                    <div class="col-auto">
                                        <input type="date" id="fecha" name="fecha" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                            Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- botones de interccion -->
        <div class="col-md-4">
            <div class="card shadow h-100 d-flex">
                <div class="card-body bg-dark shadow-xl">
                    <div class="card-title">
                        <p>Botones de Interaccion</p>
                        <hr>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-auto">
                                <form action="{{ route('ingresoegresos.store') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i>
                                        Actualizar o Guardar
                                    </button>
                                </form>
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-danger">
                                    <i class="fas fa-print"></i>
                                    Imprimir
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- saldo inicial del dia -->
<section class="container-fluid">
    <div class="row">
        <div class="col-lg-2 offset-lg-10">
            <div class="">
                <table class="table table-striped table-hover table-bordered mt-2">
                    <thead class="table-dark">
                        <th style="text-align:right;">Saldo Inicial del dia:</th>
                        <td>{{ $saldoDiaAnterior  }}</td>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- saldo final del dia -->
<section class="container-fluid">
    <div class="row">
        <div class="col-lg-2 offset-lg-10">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="text-align:right;">Saldo Final del dia:</th>
                    <td>{{ $sumaCursosAlquileresAnteriorActual }}</td>
                </thead>
            </table>
        </div>
    </div>
</section>
<!-- titulo 1 -->
<div class="card bg-dark text-white">
    <div class="card-body">
        <h3>DETALLE DE DOCUMENTOS RECEPCION DE INGRESOS</h3>
    </div>
</div>

<section class="container-fluid">
    <!-- tabla de alquileres -->
    <div class="row">
        <div class="col-md-12">
            <h4>Alquiler de Andamios</h4>
            <table class="table table-striped table-hover mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Nombre de persona o empresa</th>
                    <th>Detalle</th>
                    <th>Modulos</th>
                    <th>Plataforma</th>
                    <th>Retraso de entrega</th>
                    <th>Nro de comprobante</th>
                    <th>Ingresos</th>
                    <!-- <th>Acciones</th> -->
                </thead>
                <tbody>
                    @foreach($alquileres as $alquilere)
                    <tr>
                        <td style="display: none">{{$alquilere->id}}</td>
                        <td>{{$alquilere->created_at->format('Y-m-d')}}</td>
                        <td>{{$alquilere->Nombre_de_persona_o_empresa}}</td>
                        <td>{{$alquilere->Detalle}}</td>
                        <td>{{$alquilere->Modulos}}</td>
                        <td>{{$alquilere->Plataforma}}</td>
                        <td>{{$alquilere->Retraso_de_entrega}}</td>
                        <td>{{$alquilere->Nro_de_comprobante}}</td>
                        <td>{{$alquilere->Ingresos}}</td>
                        <!-- <td>
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
                    </td> -->
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active">
                        <td colspan="7" style="text-align:right;">Total</td>
                        <td>{{ $sumaAlquileresActual }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- tabla de cursos -->
            <h4>Cursos</h4>
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Nombre de persona anticipo</th>
                    <th>Porcentaje de anticipo</th>
                    <th>Nombre de persona pago total</th>
                    <th>Detalle de curso</th>
                    <th>Numero de comprobante</th>
                    <th>Ingresos</th>
                    <th>Metodo de Pago</th>
                    <!-- <th>Acciones</th> -->
                </thead>
                <tbody>
                    @foreach($cursos as $curso)
                    <tr>
                        <td style="display: none">{{$curso->id}}</td>
                        <td>{{$curso->created_at->format('Y-m-d')}}</td>
                        <td>{{$curso->Nombre_de_persona}}</td>
                        <td>{{$curso->Porcentaje_de_anticipo}}</td>
                        <td>{{$curso->Nombre_de_persona_pago_total}}</td>
                        <td>{{$curso->Detalle_de_curso}}</td>
                        <td>{{$curso->Numero_de_comprobante}}</td>
                        <td>{{$curso->Ingresos}}</td>
                        <td>{{$curso->metodo_pago}}</td>
                        <!-- <td>
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
                    </td> -->
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active">
                        <td colspan="6" style="text-align:right;">Total</td>
                        <td>{{ $sumaCursosActual }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- total de tablas cursos y alquileres  -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-11">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="text-align:right;">TOTAL INGRESO</th>
                    <td>{{ $sumaCursosAlquileresAnteriorActual }}</td>
                </thead>
            </table>
        </div>
    </div>
</section>

<!-- las otras dos tablas  -->
<BR></BR>

<!-- Seccion donde se guarda los datos del corte -->
<section class="container-fluid">
    <div class="col-lg-2 offset-lg-10">
        <div id="tablaDatos" data-url="{{ route('depositos.store') }}">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <tr style="font-weight: bold;">
                        <th>CORTE</th>
                        <th>TOTAL (Bs)</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diarios as $diario)
                    <tr class="">
                        <td>MONEDAS</td>
                        <td>
                            @if($ultimoRegistro)
                            {{ $ultimoRegistro->monedas }}
                            @else
                            0
                            @endif
                        </td>
                    </tr>
                    <tr class="">
                        <td>BILLETES</td>
                        <td>
                            @if($ultimoRegistro)
                            {{ $ultimoRegistro->billetes }}
                            @else
                            0
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;">
                        <td>TOTAL</td>
                        <td>{{ $sumaRecorte }}</td>
                        <td>

                            @can('editar-corte')
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                                <i class="fas fa-plus"></i>
                                Añadir
                            </button>
                            @endcan

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- se verifica errores -->
@if ($errors->any())
<div class="alert alert-dark alert-dimissible fade show" role="alert">
    <strong>¡Revise los campos >:c!</strong>
    @foreach ($errors->all() as $error)
    <span class="badge badge-danger">{{$error}}</span>
    @endforeach
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif
<!-- Modal donde añado los datos del corte-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Añadir Datos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formData">
                    @csrf
                    <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">
                    <div class="form-group">
                        <label for="monedas">Monedas</label>
                        <input type="text" class="form-control" id="monedas" name="monedas">
                    </div>
                    <div class="form-group">
                        <label for="billetes">Billetes</label>
                        <input type="text" class="form-control" id="billetes" name="billetes">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-url="{{ route('diarios.store') }}" onclick="guardarDatos()" data-dismiss="modal">Guardar</button>
            </div>
        </div>
    </div>
</div>
<!-- titulo 2 -->
<div class="card bg-dark text-white">
    <div class="card-body">
        <h3>DETALLE DE INGRESO DE EFECTIVO EN CAJA</h3>
    </div>
</div>
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h4>Depositos</h4>
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Nro de transaccion</th>
                    <th>Nombre</th>
                    <th>Monto</th>
                    <!-- <th>Acciones</th> -->
                </thead>
                <tbody>
                    @foreach($depositos as $deposito)
                    <tr>
                        <td style="display: none">{{$deposito->id}}</td>
                        <td>{{$deposito->created_at->format('Y-m-d')}}</td>
                        <td>{{$deposito->Nro_de_transaccion}}</td>
                        <td>{{$deposito->Nombre}}</td>
                        <td>{{$deposito->Monto}}</td>
                        <!-- <td>
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
                    </td> -->
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active">
                        <td colspan="3" style="text-align:right;">Total</td>
                        <td>{{ $sumaDepositosActual }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- tabla de gastos -->
            <h4>Gasto Extraordinario</h4>
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Motivo resumido de salida de dinero</th>
                    <th>Nombre a quien se entrego el dinero</th>
                    <th>Quien aprobo la entrega de dinero</th>
                    <th>Nro de comprobante</th>
                    <th>Monto</th>
                    <!-- <th>Acciones</th> -->
                </thead>
                <tbody>
                    @foreach($gastos as $gasto)
                    <tr>
                        <td style="display: none">{{$gasto->id}}</td>
                        <td>{{$gasto->created_at->format('Y-m-d')}}</td>
                        <td>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</td>
                        <td>{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}</td>
                        <td>{{$gasto->Quien_aprobo_la_entrega_de_dinero}}</td>
                        <td>{{$gasto->Nro_de_comprobante}}</td>
                        <td>{{$gasto->Monto}}</td>
                        <!-- <td>
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
                        </td> -->
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active">
                        <td colspan="5" style="text-align:right;">Total</td>
                        <td>{{ $sumaGastosActual }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<!-- suma de las tablas de corte, depositos y gastos -->
<section class="container-fluid pb-5">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="text-align:right;">TOTAL INGRESO EN EFECTIVO EN CAJA</th>
                    <td>{{ $sumaDepGasRecActual }}</td>
                </thead>
            </table>
        </div>
    </div>
</section>

<!-- footer -->
<footer class="bg-dark text-center pt-4">
    <!-- Copyright -->
    <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
        © 2023 Copyright:
        <a class="text-body" href="#">Ludeño.com</a>
    </div>
    <!-- Copyright -->
</footer>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/tablasResposive.css') }}">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('js/formCorte.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop