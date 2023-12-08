document.getElementById('metodo_pago').addEventListener('change', function () {
    var metodoPago = this.value;
    if (metodoPago === 'deposito') {
        document.getElementById('campos_deposito').style.display = 'block';
    } else {
        document.getElementById('campos_deposito').style.display = 'none';
    }
});


