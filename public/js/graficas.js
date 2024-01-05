// Acceder a los datos desde los atributos de datos del elemento
var grafica = document.getElementById('grafica');
var fechas = JSON.parse(grafica.getAttribute('data-fechas'));
var ingresos = JSON.parse(grafica.getAttribute('data-ingresos'));
var egresos = JSON.parse(grafica.getAttribute('data-egresos'));

// Crear la gráfica con Highcharts
Highcharts.chart('grafica', {
  title: {
    text: 'Ingresos y Egresos'
  },
  xAxis: {
    categories: fechas
  },
  yAxis: {
    title: {
      text: 'Cantidad'
    }
  },
  series: [{
    name: 'Ingresos',
    data: ingresos
  }, {
    name: 'Egresos',
    data: egresos
  }]
});