function guardarDatos() {
    // Obtener los valores del formulario
    var monedas = $('#monedas').val();
    var billetes = $('#billetes').val();
    var url = $('button.btn-primary').data('url');
    var csrfToken = $('#csrf-token').val(); 

    // Enviar los datos al servidor usando AJAX
    $.ajax({
      type: 'POST',
      url: url, // Reemplaza con la URL de tu controlador en Laravel
      data: {
        monedas: monedas,
        billetes: billetes,
        _token: csrfToken // Agrega el token CSRF para protección
      },
      success: function(response) {
        // Manejar la respuesta del servidor, por ejemplo, cerrar el modal
        $('#exampleModal').modal('hide');
        // Puedes hacer más acciones aquí según tu lógica de la aplicación
      },
      error: function(error) {
        console.log(error);
        // Manejar errores si es necesario
      }
    });
  }

