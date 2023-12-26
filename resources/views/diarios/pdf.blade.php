<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF-INFORME DIARIO DE CAJA</title>
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
            <h4 style="padding: 6px; border: 1px solid black; margin-bottom: 6px;">INFORME DIARIO DE CAJA</h4>
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
                        <table style="float: right;">
                            <tr style="background-color: #A0C49D;">
                                <th style="width: 30%; font-size:10px;">Fecha Reporte</th>
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
    <!-- tabla de saldos  -->
    <section>
        <div>
            <table style="width: 100%; border-collapse: collapse;">
                <tr class="sin-bordes">
                    <td class="sin-bordes"></td>
                    <td class="sin-bordes">
                        <!-- tabla de saldo inicial del dia -->
                        <table style="float: right;">
                            <tr>
                                <th style="text-align:right; background-color: #A0C49D; ">Saldo Inicial del dia:</th>
                                <td>{{ $saldoDiaAnterior }}</td>
                            </tr>
                        </table>
                        <div style="clear: both;"></div> <!-- Elemento de limpieza -->
                    </td>
                </tr>
                <!-- fecha de reporte -->
                <tr class="sin-bordes">
                    <td class="sin-bordes" style="width: 50%;">
                        <table style="border-collapse: collapse;">
                            <td class="sin-bordes" style="padding: 0; margin: 0;">
                                <p style="font-weight: bold; font-size:12px; margin-top: 1; margin-bottom:2x;">Reporte del dia <span>{{ $fechaActualFormateada }}</span></p>
                            </td>
                        </table>
                    </td>
                    <!-- tabla de saldo final del dia  -->
                    <td class="sin-bordes" style="width: 50%; vertical-align: top;">
                        <table style="border-collapse: collapse; float: right;">
                            <thead>
                                <th style="text-align:right; background-color: #A0C49D; padding: 5; margin: 0;">Saldo Final del dia:</th>
                                <td>{{ $sumaCursosAlquileresAnteriorActual }}</td>
                            </thead>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <!-- TITULO 1 -->
    <section>
        <div style="background-color: #A0C49D;">
            <h4 style="padding: 6px; border: 1px solid black; margin-top:6px; margin-bottom:-6px;">1 .- DETALLE DE DOCUMENTOS DE RECEPCION DE INGRESO: </h4>
        </div>
    </section>
    <!-- titulo -->
    <section>
        <div class="titulo">
            <h4 style="padding: 6px; border: 1px solid black; margin-bottom: 6px;">ALQUILER DE ANDAMIOS</h4>
        </div>
    </section>
    <!-- tabla de alquileres -->
    <section>
        <table style=" width: 100%;">
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
                    <td>{{ $sumaAlquileresActual }}</td>
                </tr>
            </tbody>
        </table>
    </section>
    <!-- titulo 2 -->
    <section>
        <div class="titulo">
            <h4 style="padding: 6px; border: 1px solid black; margin-top:6px; margin-bottom: 6px;">CURSOS DE SKETCH UP, CARPINTERIA EN ALUMINIO, ETC.</h4>
        </div>
    </section>
    <!-- TABLA DE CURSOS -->
    <section>
        <table>
            <thead style="background-color: #A0C49D;">
                <th style="display: none">ID</th>
                <th>Fecha</th>
                <th>Nombre de persona anticipo</th>
                <th>Porcentaje de anticipo</th>
                <th>Nombre de persona pago total</th>
                <th>Detalle de curso</th>
                <th>Numero de comprobante</th>
                <th>Ingresos</th>
                <th>Metodo de Pago</th>
            </thead>
            <tbody>
                @foreach($cursos as $curso)
                <tr>
                    <td style="display: none">{{$curso->id}}</td>
                    <td class="fecha">{{$curso->created_at->format('Y-m-d')}}</td>
                    <td>{{$curso->Nombre_de_persona}}</td>
                    <td>{{$curso->Porcentaje_de_anticipo}}</td>
                    <td>{{$curso->Nombre_de_persona_pago_total}}</td>
                    <td>{{$curso->Detalle_de_curso}}</td>
                    <td>{{$curso->Numero_de_comprobante}}</td>
                    <td>{{$curso->Ingresos}}</td>
                    <td>{{$curso->metodo_pago}}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold;">
                    <td colspan="6" style="text-align:right;">Total</td>
                    <td>{{ $sumaCursosActual }}</td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </section>
    <!-- total de las tablas cursos y alquileres -->
    <section>
        <table style="background-color: #A0C49D; width: 100%;">
            <thead>
                <th style="text-align:right; width: 82%;">TOTAL INGRESO</th>
                <td>{{ $sumaCursosAlquileresAnteriorActual }}</td>
            </thead>
        </table>
    </section>
    <!-- titulo 3 -->
    <section>
        <div style="background-color: #A0C49D;">
            <h4 style="padding: 6px; border: 1px solid black; margin-bottom: 6px;">2.- DETALLE DE INGRESO DE EFECTIVO EN CAJA:</h4>
        </div>
    </section>
    <!-- Tabla de corte -->
    <section>
        <table style="float: right;">
            <thead style="background-color: #A0C49D; font-weight: bold;">
                <th>CORTE</th>
                <th>TOTAL (Bs)</th>
            </thead>
            <tbody>
                @foreach ($diarios as $diario)
                <tr>
                    <td>MONEDAS</td>
                    <td>
                        @if($ultimoRegistro)
                        {{ $ultimoRegistro->monedas }}
                        @else
                        0
                        @endif
                    </td>
                </tr>
                <tr>
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
                </tr>
            </tbody>
        </table>
        <div style="clear: both;"></div> <!-- Elemento de limpieza -->
    </section>
    <!-- titulo 4 -->
    <section>
        <div class="titulo">
            <h4 style="padding: 6px; border: 1px solid black; margin-bottom: 6px; margin-top:6px;">DEPOSITOS</h4>
        </div>
    </section>
    <!-- TABLA DE DEPOSITOS -->
    <section>
        <table style="width: 100%;">
            <thead style="background-color: #A0C49D;">
                <th style="display: none">ID</th>
                <th>Fecha</th>
                <th>Nro de transaccion</th>
                <th>Nombre</th>
                <th>Monto</th>
            </thead>
            <tbody>
                @foreach($depositos as $deposito)
                <tr>
                    <td style="display: none">{{$deposito->id}}</td>
                    <td class="fecha">{{$deposito->created_at->format('Y-m-d')}}</td>
                    <td>{{$deposito->Nro_de_transaccion}}</td>
                    <td>{{$deposito->Nombre}}</td>
                    <td>{{$deposito->Monto}}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold;">
                    <td colspan="3" style="text-align:right;">Total</td>
                    <td>{{ $sumaDepositosActual }}</td>
                </tr>
            </tbody>
        </table>
    </section>
    <!-- titulo 5 -->
    <section>
        <div class="titulo">
            <h4 style="padding: 6px; border: 1px solid black; margin-bottom: 6px; margin-top:6px;">GASTO EXTRAORDINARIO</h4>
        </div>
    </section>
    <!-- tabla de gastos -->
    <section>
        <table>
            <thead style="background-color: #A0C49D;">
                <th style="display: none">ID</th>
                <th>Fecha</th>
                <th>Motivo resumido de salida de dinero</th>
                <th>Nombre a quien se entrego el dinero</th>
                <th>Quien aprobo la entrega de dinero</th>
                <th>Nro de comprobante</th>
                <th>Monto</th>
            </thead>
            <tbody>
                @foreach($gastos as $gasto)
                <tr>
                    <td style="display: none">{{$gasto->id}}</td>
                    <td class="fecha">{{$gasto->created_at->format('Y-m-d')}}</td>
                    <td>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</td>
                    <td>{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}</td>
                    <td>{{$gasto->Quien_aprobo_la_entrega_de_dinero}}</td>
                    <td>{{$gasto->Nro_de_comprobante}}</td>
                    <td>{{$gasto->Monto}}</td>
                </tr>
                @endforeach
                <tr style="font-weight: bold;" class="table-active">
                    <td colspan="5" style="text-align:right;">Total</td>
                    <td>{{ $sumaGastosActual }}</td>
                </tr>
            </tbody>
        </table>
    </section>
    <!-- suma de las tablas gastos y depositos -->
    <section>
        <table style="background-color: #A0C49D; width: 100%;">
            <thead>
                <th style="text-align:right; width: 94%;">TOTAL INGRESO EN EFECTIVO EN CAJA</th>
                <td>{{ $sumaDepGasRecActual }}</td>
            </thead>
        </table>
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