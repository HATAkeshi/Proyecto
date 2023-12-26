<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF-Recibo-Gastos</title>
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
            font-size: 12px;
            border: 1px solid black;
        }

        table td {
            font-size: 12px;
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
            border: none;
        }

        .linea-firma {
            border-top: 1px solid black;
        }
    </style>
</head>

<body>
    <!-- section number one -->
    <section>
        <!-- area de datos -->
        <div>
            <table style="width:100%;" class="sin-bordes">
                <tr class="sin-bordes">
                    <td style="width: 50%; text-align: left;" class="sin-bordes">
                        <div>
                            <h1 style="font-size: 32px; ">RECIBO N° <span>{{$gasto->Nro_de_comprobante}}</span></h1>
                        </div>
                    </td>
                    <td style="width: 50%;" class="sin-bordes">
                        <img src="{{ $base64Image }}" alt="Imagen" style="width: 200px;">
                        <p style="font-size: 15px; font-weight: bold; margin-top:8px; margin-bottom:0px;">
                            Fecha:
                            <span style="font-weight: none;" class="fecha">{{$gasto->created_at->format('Y-m-d') }}</span>
                        </p>
                    </td>
                </tr>
                <tr class="sin-bordes">
                    <td style="width: 50%; text-align: left; padding:0px; margin:0px;" class="sin-bordes">
                        <p style="font-weight: bold; font-size: 20px; margin-top:-10px; margin-bottom:-8px;">Entregue a:</p>
                        <p style="font-size: 15px; font-weight: bold; ">Nombre: <span style="font-weight: none;">{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}</span></p>
                    </td>
                    <td style="width: 50%;" class="sin-bordes">
                        <p style="font-size: 12px;">Antofagasta Esq. Calle 10 N° 328 <br>
                            <span>Cel.: 70147130 - 70546730</span>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <!-- tabla con datos -->
        <div>
            <table style="width: 100%;">
                <thead style="background-color: #3887BE; color:white; font-weight: bold;">
                    <th style="display: none">ID</th>
                    <th>Descripcion del articulo</th>
                    <th>Importe</th>
                </thead>
                <tbody>
                    <tr class="sin-bordes">
                        <td style="display: none">{{$gasto->id}}</td>
                        <td>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</td>
                        <td>{{$gasto->Monto}}</td>
                    </tr>
                    <tr class="sin-bordes">
                        <td style="color:white;">text</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- tabal de totales y subtotales -->
        <div>
            <table style="width: 100%;  border-collapse: collapse; margin-top:10px;" class="sin-bordes">
                <tr class="sin-bordes">
                    <td style="width: 72%; padding:1px;" class="sin-bordes">
                        <p style="text-align:right;" class="sin-bordes">Sub total:</p><br>
                        <p style="text-align:right; margin-top:-20px; font-weight: bold;" class="sin-bordes">
                            COSTE TOTAL:
                        </p>
                    </td>
                    <td style="width: 28%; padding:0px;" class="sin-bordes">
                        <table style="float: right; width: 100%;">
                            <tbody>
                                <tr>
                                    <td>{{$gasto->Monto}}</td>
                                </tr>
                                <tr style="background-color: #3887BE; color:white; font-weight: bold;">
                                    <td>{{$gasto->Monto}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="clear: both;"></div> <!-- Elemento de limpieza -->
        </div>
        <!-- seccion de las firmas -->
        <div style="margin-top:-10px; padding:0px;">
            <table style="width: 100%; margin-top:0px; border-collapse: collapse;" class="sin-bordes">
                <tr class="sin-bordes">
                    <td style="width: 60%; text-align:center;" class="sin-bordes">
                        <!-- Línea de firma -->
                        <div class="linea-firma" style="width: 50%; margin: 0 auto;">
                            <p style="margin-top: 0px;">RECIBI CONFORME</p>
                            <p style="margin-top: -15px;">C.I.:______________</p>
                        </div>
                    </td>
                    <td style="width: 40%; text-align:center;" class="sin-bordes">
                </tr>
            </table>
        </div>
    </section>
    <!-- section number two -->
    <section style="margin-top: 10%;">
        <!-- area de datos -->
        <div>
            <table style="width:100%;" class="sin-bordes">
                <tr class="sin-bordes">
                    <td style="width: 50%; text-align: left;" class="sin-bordes">
                        <div>
                            <h1 style="font-size: 32px; ">RECIBO N° <span>{{$gasto->Nro_de_comprobante}}</span></h1>
                        </div>
                    </td>
                    <td style="width: 50%;" class="sin-bordes">
                        <img src="{{ $base64Image }}" alt="Imagen" style="width: 200px;">
                        <p style="font-size: 15px; font-weight: bold; margin-top:8px; margin-bottom:0px;">
                            Fecha:
                            <span style="font-weight: none;" class="fecha">{{$gasto->created_at->format('Y-m-d') }}</span>
                        </p>
                    </td>
                </tr>
                <tr class="sin-bordes">
                    <td style="width: 50%; text-align: left; padding:0px; margin:0px;" class="sin-bordes">
                        <p style="font-weight: bold; font-size: 20px; margin-top:-10px; margin-bottom:-8px;">Entregue a:</p>
                        <p style="font-size: 15px; font-weight: bold; ">Nombre: <span style="font-weight: none;">{{$gasto->Nombre_a_quien_se_entrego_el_dinero}}</span></p>
                    </td>
                    <td style="width: 50%;" class="sin-bordes">
                        <p style="font-size: 12px;">Antofagasta Esq. Calle 10 N° 328 <br>
                            <span>Cel.: 70147130 - 70546730</span>
                        </p>
                    </td>
                </tr>
            </table>
        </div>
        <!-- tabla con datos -->
        <div>
            <table style="width: 100%;">
                <thead style="background-color: #3887BE; color:white; font-weight: bold;">
                    <th style="display: none">ID</th>
                    <th>Descripcion del articulo</th>
                    <th>Importe</th>
                </thead>
                <tbody>
                    <tr class="sin-bordes">
                        <td style="display: none">{{$gasto->id}}</td>
                        <td>{{$gasto->Motivo_resumido_de_salida_de_dinero}}</td>
                        <td>{{$gasto->Monto}}</td>
                    </tr>
                    <tr class="sin-bordes">
                        <td style="color:white;">text</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- tabal de totales y subtotales -->
        <div>
            <table style="width: 100%;  border-collapse: collapse; margin-top:10px;" class="sin-bordes">
                <tr class="sin-bordes">
                    <td style="width: 72%; padding:1px;" class="sin-bordes">
                        <p style="text-align:right;" class="sin-bordes">Sub total:</p><br>
                        <p style="text-align:right; margin-top:-20px; font-weight: bold;" class="sin-bordes">
                            COSTE TOTAL:
                        </p>
                    </td>
                    <td style="width: 28%; padding:0px;" class="sin-bordes">
                        <table style="float: right; width: 100%;">
                            <tbody>
                                <tr>
                                    <td>{{$gasto->Monto}}</td>
                                </tr>
                                <tr style="background-color: #3887BE; color:white; font-weight: bold;">
                                    <td>{{$gasto->Monto}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="clear: both;"></div> <!-- Elemento de limpieza -->
        </div>
        <!-- seccion de las firmas -->
        <div style="margin-top:-10px; padding:0px;">
            <table style="width: 100%; margin-top:0px; border-collapse: collapse;" class="sin-bordes">
                <tr class="sin-bordes">
                    <td style="width: 60%; text-align:center;" class="sin-bordes">
                        <!-- Línea de firma -->
                        <div class="linea-firma" style="width: 50%; margin: 0 auto;">
                            <p style="margin-top: 0px;">RECIBI CONFORME</p>
                            <p style="margin-top: -15px;">C.I.:______________</p>
                        </div>
                    </td>
                    <td style="width: 40%; text-align:center;" class="sin-bordes">
                </tr>
            </table>
        </div>
    </section>
</body>

</html>