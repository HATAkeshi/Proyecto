@extends('adminlte::page')

@section('title', 'Ludeño|Grafica')

@section('content_header')
<div class="card bg-dark text-white">
  <div class="card-body">
    <h2>Grafica de Ingresos - Egresos</h2>
  </div>
</div>
@stop

@section('content')

<div class="container mt-5">
  <div class="row">
    <div class="col">
      <div id="container" data-fechas="{{ json_encode($fechas) }}" data-ingresos="{{ json_encode($ingresos) }}" data-egresos="{{ json_encode($egresos) }}">
      </div>
    </div>
  </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
@stop

@section('js')
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
<!-- script para las graficas -->
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
  // Obtener los datos del servidor utilizando PHP y json_encode
  var container = document.getElementById('container');
  var fechas = container.getAttribute('data-fechas');
  var ingresos = container.getAttribute('data-ingresos');
  var egresos = container.getAttribute('data-egresos');

  // Convertir los datos a objetos JavaScript
  fechas = JSON.parse(fechas);
  ingresos = JSON.parse(ingresos);
  egresos = JSON.parse(egresos);


  // Configura la gráfica usando los datos que pasaste desde el controlador
  Highcharts.chart('container', {
    chart: {
      type: 'line'
    },
    title: {
      text: 'Ingresos y Egresos'
    },
    xAxis: {
      categories: fechas // Fechas como categorías en el eje X
    },
    yAxis: {
      title: {
        text: 'Cantidad'
      }
    },
    series: [{
      name: 'Ingresos',
      data: ingresos, // Datos de ingresos
      animation: {
        duration: 1000 // Duración en milisegundos de la animación
      },
      color: 'green',
    }, {
      name: 'Egresos',
      data: egresos, // Datos de egresos
      animation: {
        duration: 1000 // Duración en milisegundos de la animación
      },
      color: 'red',
    }]
  });
</script>
@stop