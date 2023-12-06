// ajax.js

$(document).ready(function() {
    // Manejar el clic en las opciones del submenú
    $('.form-submenu').click(function(event) {
        event.preventDefault();

        // Obtener la URL de la opción del submenú
        var url = $(this).attr('href');

        // Realizar la petición AJAX para obtener el contenido del formulario
        $.get(url, function(data) {
            // Colocar el contenido del formulario en el contenedor deseado en el dashboard
            $('#formularioCarpiteria').html(data);
        });
    });
});
