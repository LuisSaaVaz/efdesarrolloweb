/**
 * Muestra un mensaje flotante utilizando el Toast de Bootstrap.
 * @param {string} mensaje - Texto a mostrar.
 * @param {boolean} esError - Si es true se pinta rojo (danger), si es false verde (success).
 */
function mostrarToast(mensaje, esError = false) {
    const $toastEl = $('#liveToast');
    
    if ($toastEl.length) {
        $('#toastBody').text(mensaje);
        
        if (esError) {
            $toastEl.removeClass('bg-success text-white').addClass('bg-danger text-white');
        } else {
            $toastEl.removeClass('bg-danger text-white').addClass('bg-success text-white');
        }

        const toast = bootstrap.Toast.getOrCreateInstance($toastEl[0]);
        toast.show();
    } else {
        console.log((esError ? '[ERROR] ' : '[OK] ') + mensaje);
    }
}