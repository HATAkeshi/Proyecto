document.addEventListener("DOMContentLoaded", function () {
    const formulario = document.getElementById('miFormulario');
    const metodoPago = document.getElementById('metodo_pago');

    metodoPago.addEventListener('change', function () {
        const selectedOption = metodoPago.value;

        // Obtener todos los campos que requieren validación condicional
        const camposValidar = document.querySelectorAll('#miFormulario [data-validacion-condicional]');

        // Habilitar o deshabilitar las validaciones según el método de pago seleccionado
        camposValidar.forEach(function (campo) {
            if (selectedOption === 'deposito') {
                campo.setAttribute('required', '');
            } else {
                campo.removeAttribute('required');
            }
        });
    });
});