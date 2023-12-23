// confirmacion_eliminar.js
document.querySelectorAll('.deleteForm').forEach(form => {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        Swal.fire({
            title: '¿Estás seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo'
        }).then((result) => {
            if (result.isConfirmed) {
                // Si confirma, envía el formulario para eliminar
                form.submit();
            }
        });
    });
});
