@extends('adminlte::page')

@section('title', 'Ludeño|Ingresos Egresos')

@section('content_header')
<div class="card bg-dark text-white">
    <div class="card-body">
        <h2>Informes de Ingresos Egresos</h2>
    </div>
</div>
@stop

@section('content')

<!-- filtrador por fecha y los botones de interaccion-->
<section class="container-fluid mt-4">
    <div class="row justify-content-start">
        <!-- botones de interccion -->
        <div class="col-md-4">
            <div class="card shadow h-100 d-flex">
                <div class="card-body bg-dark shadow-xl">
                    <div class="card-title">
                        <p style="font-weight: bold;">Botones de Interaccion</p>
                        <hr>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-auto">
                                @php
                                $url = request()->fullUrl(); // Obtener la URL completa actual
                                $params = parse_url($url); // Parsear la URL para obtener sus componentes

                                // Extraer y convertir los parámetros de la URL en un array asociativo
                                parse_str($params['query'] ?? '', $query);

                                // Agregar el parámetro generar_pdf
                                $query['generar_pdf'] = true;

                                // Obtener la ruta base y agregar los parámetros como query string
                                $route = route('ingresoegresos.index') . '?' . http_build_query($query);
                                @endphp
                                <a href="{{ $route }}" type="button" class="btn btn-danger mb-2" target="_blank">
                                    <i class="fas fa-print"></i>
                                    Imprimir
                                </a>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('ingresoegresos.index') }}" method="GET" id="ordenarForm">
                                    <div class="row mt-n1 align-items-center">
                                        <div class="col-auto">
                                            <select class="form-select mt-1" name="orden" id="ordenSelect">
                                                <option value="asc" {{ request('orden') == 'asc' ? 'selected' : '' }}>
                                                    Ascendente
                                                </option>
                                                <option value="desc" {{ request('orden') == 'desc' ? 'selected' : '' }}>
                                                    Descendente
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn btn-warning mt-1" type="submit" id="ordenarButtonFechaRango">
                                                <i class="fas fa-sort-alpha-down fa-lg"></i>
                                                Ordenar
                                            </button>
                                            <br>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- busqueda por fecha -->
        <div class="col-md-4">
            <div class="card shadow h-100 d-flex">
                <div class="card-body bg-dark shadow-xl">
                    <div class="card-title">
                        <p style="font-weight: bold;">Busqueda por fecha</p>
                        <hr>
                    </div>
                    <div class="card-text">
                        <div class="row">
                            <form method="GET" action="{{ route('ingresoegresos.index') }}">
                                @csrf
                                <div class="row mb-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="fecha_inicio">Fecha Inicial:</label>
                                        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control">
                                    </div>
                                    <div class="col-auto">
                                        <label for="fecha_inicio">Fecha Final:</label>
                                        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control">
                                    </div>
                                    <div class="col-auto mt-4">
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
    </div>
</section>
<!-- tabla de Ingresos Egresos Diarios -->
<section class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover table-bordered mt-2">
                <thead class="table-dark">
                    <th style="display: none">ID</th>
                    <th>Fecha</th>
                    <th>Detalle</th>
                    <th>Nombre</th>
                    <th>Ingreso</th>
                    <th>Egreso</th>
                    <th>Saldo</th>
                </thead>
                <tbody>
                    @foreach($ingresoegresos as $ingresoegreso)
                    <tr class="{{ $ingresoegreso->Detalle === 'Domingo - Feriado - Etc' ? 'table-warning' : '' }}">
                        <td style="display: none">{{$ingresoegreso->id}}</td>
                        <td>{{$ingresoegreso->fecha}}</td>
                        <td>{{$ingresoegreso->Detalle}}</td>
                        <td>{{$ingresoegreso->Nombre}}</td>
                        <td>{{$ingresoegreso->Ingreso}}</td>
                        <td>{{$ingresoegreso->Egreso}}</td>
                        <td>{{$ingresoegreso->Saldo}}</td>
                    </tr>
                    @endforeach
                    <tr style="font-weight: bold;" class="table-active bg-dark">
                        <td colspan="3" style="text-align:right;">A Total Ingreso</td>
                        <td>{{$sumaIngresos}}</td>
                    </tr>
                    <tr style="font-weight: bold;" class="table-active bg-dark">
                        <td colspan="4" style="text-align:right;">B Total Egreso</td>
                        <td>{{$sumaEgresos}}</td>
                    </tr>
                    <tr style="font-weight: bold;" class="table-active bg-dark">
                        <td colspan="5" style="text-align:center;">TOTAL INGRESO NETO A-B</td>
                        <td>{{$sumaSaldo}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<!-- paginacion -->
<div class="pagination justify-content-center">
    {!! $ingresoegresos->links() !!}
</div>
@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/tablasResposive.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- para la filtracion y ordenamiento -->
<script src="{{ asset('js/FiltracionesOrdenamientoRangos.js') }}"></script>
<script>
    console.log('Hola');
</script>
@stop