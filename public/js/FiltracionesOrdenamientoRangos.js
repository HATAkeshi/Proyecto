//script para manejar fechas por rango y su ordemamiento
document.getElementById('ordenarButtonFechaRango').addEventListener('click', function(event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del botón
    
    var currentUrl = window.location.href;
    var url = new URL(currentUrl);
    var fechaInicio = url.searchParams.get("fecha_inicio");
    var fechaFin = url.searchParams.get("fecha_fin");
    var selectedOrder = document.getElementById("ordenSelect").value;

    if ((fechaInicio && fechaFin) || (!fechaInicio && !fechaFin)) {
        if (fechaInicio && fechaFin) {
            url.searchParams.set("orden", selectedOrder);
            window.location.href = url.href;
        } else {
            document.getElementById('ordenarForm').submit();
        }
    } else {
        var newUrl = new URL(window.location.href); // Crear una nueva URL para preservar los parámetros existentes
        newUrl.searchParams.set("orden", selectedOrder); // Establecer el nuevo parámetro de orden

        if (fechaInicio) {
            newUrl.searchParams.set("fecha_inicio", fechaInicio); // Preservar la fecha de inicio
        }

        if (fechaFin) {
            newUrl.searchParams.set("fecha_fin", fechaFin); // Preservar la fecha de fin
        }

        window.location.href = newUrl.href; // Redireccionar a la nueva URL con los parámetros actualizados
    }
})
