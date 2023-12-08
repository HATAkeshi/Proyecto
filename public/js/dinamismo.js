$(document).ready(function() {
    $('#metodo_pago').on('change', function() {
        if ($(this).val() === 'deposito') {
            $('#campos_deposito').show();
        } else {
            $('#campos_deposito').hide();
        }
    });

    // Ocultar los campos de depósito si el método de pago no es "depósito" al cargar la página
    if ($('#metodo_pago').val() !== 'deposito') {
        $('#campos_deposito').hide();
    }
});