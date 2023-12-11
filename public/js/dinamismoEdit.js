// mi_script.js

$('#metodo_pago').change(function() {
    console.log("Valor seleccionado:", $(this).val()); // Agrega este console.log para verificar el valor seleccionado
    if ($(this).val() === 'deposito') {
        $('#campos_deposito').show();
    } else {
        $('#campos_deposito').hide();
    }
});

$(document).ready(function() {
    if ($('#metodo_pago').val() === 'deposito') {
        $('#campos_deposito').show();
    } else {
        $('#campos_deposito').hide();
    }
});
