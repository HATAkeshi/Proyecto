function guardarDatos() {
    // Obtener los valores del formulario
    var monedas = $('#monedas').val();
    var billetes = $('#billetes').val();
    var url = $('button.btn-primary').data('url');
    var csrfToken = $('#csrf-token').val(); 

    // Enviar los datos al servidor usando AJAX
    $.ajax({
      type: 'POST',
      url: url, 
      data: {
        monedas: monedas,
        billetes: billetes,
        _token: csrfToken // Agrega el token CSRF para protección
      },
      success: function(response) {
        location.reload(true);
    },
      error: function(error) {
        console.log(error);
      }
    });
  }

