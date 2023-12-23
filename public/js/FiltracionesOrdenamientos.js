document.getElementById('ordenarButtonFecha').addEventListener('click', function(event) {
    event.preventDefault(); // Prevenir el comportamiento predeterminado del botón
    
    var currentUrl = window.location.href;
    var url = new URL(currentUrl);
    var fecha = url.searchParams.get("fecha");
    var selectedOrder = document.getElementById("ordenSelect").value;

    if (fecha) {
        url.searchParams.set("orden", selectedOrder);
        window.location.href = url.href;
    } else {
        // Si no hay fecha, envía el formulario para filtrar por la fecha actual y ordenar
        document.getElementById('ordenarForm').submit();
    }
});







