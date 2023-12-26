<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF-Ingresos-Egresos</title>
    <style>
        * {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        table {
            border-collapse: collapse;
            border: 1px solid black;
        }

        table td,
        th {
            padding: 5px;
            text-align: center;
            font-size: 10px;
            border: 1px solid black;
        }

        table td {
            font-size: 10px;
            margin: -5px;
            border: 1px solid black;
        }

        table tr {
            border: 1px solid black;
        }

        .fecha {
            white-space: nowrap;
        }

        .titulo {
            text-align: center;
            background-color: #A0C49D;
        }

        .sin-bordes {
            border-collapse: collapse;
            border-color: white;
        }

        .linea-firma {
            border-top: 1px solid black;
        }

        /* Estilo cuando el Detalle es 'Domingo - Feriado - Etc' */
        .celda-destacada {
            background-color: #FFE382;
        }
    </style>
</head>

<body>
    <!-- titulo 1 -->
    <section>
        <div class="titulo">
            <h4 style="padding: 6px; border: 1px solid black; margin-bottom: 6px;">INFORME DE INGRESOS EGRESOS</h4>
        </div>
    </section>
    <!-- reporte de rangos por fechas -->
    <section>
        <div>
            <table style="width: 100%;">
                <!-- fecha de reporte -->
                <td class="sin-bordes" style="padding: 0; margin: 0;">
                    <p style="font-weight: bold; font-size:12px; margin-top: -4;">Del <span>{{ $fechaFormateadaInicio }}</span> al <span>{{ $fechaFormateadaFin }}</span></p>
                </td>
            </table>
        </div>
    </section>
    <!-- fecha y hora -->
    <section>
        <div style="margin-top:-10px;">
            <table style="width: 100%;">
                <tr class="sin-bordes">
                    <td class="sin-bordes">
                        <!-- nombre de encargado -->
                        <table style="margin-left: -6px;">
                            <tr style="background-color: #A0C49D;">
                                <th style="width: 25%; font-size:10px;">Nombre del encargado</th>
                                <th style="width: 20%; font-size:10px;">Cargo</th>
                            </tr>
                            <tr>
                                <td style="width: 20%;">{{ $nombreUsuario }}</td>
                                <td style="width: 20%;">{{ $rolUsuario }}</td>
                            </tr>
                        </table>
                    </td>
                    <td class="sin-bordes">
                        <table style="float: right;">
                            <tr style="background-color: #A0C49D;">
                                <th style="width: 25%; font-size:10px;">Fecha Reporte</th>
                                <th style="width: 20%; font-size:10px;">Hora</th>
                            </tr>
                            <tr>
                                <td style="width: 20%;">{{ $fecha_actual }}</td>
                                <td style="width: 20%;">{{ $hora_actual }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <!-- tabla de ingresos egresos -->
    <section>
        <div>
            <div>
                <table style="width: 100%;">
                    <thead style="background-color: #A0C49D;">
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
                        <tr class="{{ $ingresoegreso->Detalle === 'Domingo - Feriado - Etc' ? 'celda-destacada' : '' }}">
                            <td style="display: none">{{$ingresoegreso->id}}</td>
                            <td class="fecha">{{$ingresoegreso->fecha}}</td>
                            <td>{{$ingresoegreso->Detalle}}</td>
                            <td>{{$ingresoegreso->Nombre}}</td>
                            <td>{{$ingresoegreso->Ingreso}}</td>
                            <td>{{$ingresoegreso->Egreso}}</td>
                            <td>{{$ingresoegreso->Saldo}}</td>
                        </tr>
                        @endforeach
                        <tr style="font-weight: bold;">
                            <td colspan="3" style="text-align:right; background-color:#BED754;">A Total Ingreso</td>
                            <td style="background-color:#BED754;">{{$sumaIngresos}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="font-weight: bold;">
                            <td colspan="4" style="text-align:right; background-color:#EB455F;">B Total Egreso</td>
                            <td style="background-color:#EB455F;">{{$sumaEgresos}}</td>
                            <td></td>
                        </tr>
                        <tr style="font-weight: bold; background-color:#C6CF9B;">
                            <td colspan="5" style="text-align:center;">TOTAL INGRESO NETO A-B</td>
                            <td>{{$sumaSaldo}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- section de la firma -->
    <section>
        <table style="width: 100%; margin-top:60px;">
            <tr class="sin-bordes">
                <td style="width: 50%; text-align:center;" class="sin-bordes">
                    <!-- Línea de firma -->
                    <div class="linea-firma" style="width: 50%; margin: 0 auto;">
                        <p>Entregdo por:</p>
                        <p style="margin: -5px;">{{ $nombreUsuario }}</p>
                        <p>C.I.:______________</p>
                    </div>
                </td>
                <td style="width: 50%; text-align:center;" class="sin-bordes">
                    <div class="linea-firma" style="width: 50%; margin: 0 auto;">
                        <p style="margin-bottom:40px;">Recibo por:________________</p>
                    </div>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>