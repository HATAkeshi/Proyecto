<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF-Alquileres</title>
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
    </style>
</head>

<body>
    <section>
        <div class="titulo">
            <h4 style="padding: 6px; border: 1px solid black; margin-bottom: 6px;">INFORME DE ALQUILERES</h4>
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
        <div>
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
                        <table style="float:right;">
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
    <!-- tabla de cursos -->
    <section>
        <div>
            <div>
                <table style="width: 100%;">
                    <thead style="background-color: #A0C49D;">
                        <th style="display: none">ID</th>
                        <th>Fecha</th>
                        <th>Nombre de persona o empresa</th>
                        <th>Detalle</th>
                        <th>Modulos</th>
                        <th>Plataforma</th>
                        <th>Retraso de entrega</th>
                        <th>Nro de comprobante</th>
                        <th>Ingresos</th>
                    </thead>
                    <tbody>
                        @foreach($alquileres as $alquilere)
                        <tr>
                            <td style="display: none">{{$alquilere->id}}</td>
                            <td class="fecha">{{$alquilere->created_at->format('Y-m-d')}}</td>
                            <td>{{$alquilere->Nombre_de_persona_o_empresa}}</td>
                            <td>{{$alquilere->Detalle}}</td>
                            <td>{{$alquilere->Modulos}}</td>
                            <td>{{$alquilere->Plataforma}}</td>
                            <td>{{$alquilere->Retraso_de_entrega}}</td>
                            <td>{{$alquilere->Nro_de_comprobante}}</td>
                            <td>{{$alquilere->Ingresos}}</td>
                        </tr>
                        @endforeach
                        <tr style="font-weight: bold;">
                            <td colspan="7" style="text-align:right;">Total</td>
                            <td>{{ $sumaAlquileres }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <!-- seccion de las firmas -->
    <section>
        <table style="width: 100%; margin-top:80px;">
            <tr class="sin-bordes">
                <td style="width: 20%; text-align:center;" class="sin-bordes">
                </td>
                <td style="width: 60%; text-align:center;" class="sin-bordes">
                    <!-- Línea de firma -->
                    <div class="linea-firma" style="width: 50%; margin: 0 auto;">
                        <p>FIRMA RESPONSABLE</p>
                        <p style="margin: -5px;">{{ $nombreUsuario }}</p>
                        <p>C.I.:______________</p>
                    </div>
                </td>
                <td style="width: 20%; text-align:center;" class="sin-bordes">
                </td>
            </tr>
        </table>
    </section>
</body>

</html>