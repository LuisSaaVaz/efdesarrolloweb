$(document).ready(function () {
    $('#formCliente').on('submit', function (e) {
        e.preventDefault(); // Evita que la página se recargue

        // Crea un objeto con todos los valores mandados en el formulario
        const formData = $(this).serialize();

        // Petición simplificada con $.post(url, data, callback, dataType)
        $.post('PHP/guardar_cliente.php', formData, function (response) {
            
            mostrarToast(response.message, response.success);

            if (response.success) {
                $('#formCliente')[0].reset(); // Limpia los campos si fue exitoso
            }

        }, 'json').fail(function () {
            // Manejo del error de red o de servidor
            mostrarToast('Ocurrió un error inesperado al procesar la solicitud.', false);
        });
    });

    function mostrarToast(mensaje, esExito) {
        const $toastEl = $('#liveToast');
        const $toastBody = $('#toastMessage');

        // Configurar mensaje
        $toastBody.text(mensaje);

        // Cambiar color de fondo según el resultado
        $toastEl.removeClass('bg-success bg-danger');
        if (esExito) {
            $toastEl.addClass('bg-success');
        } else {
            $toastEl.addClass('bg-danger');
        }

        // Mostrar el Toast de Bootstrap 5
        const toast = new bootstrap.Toast($toastEl[0]);
        toast.show();
    }
});