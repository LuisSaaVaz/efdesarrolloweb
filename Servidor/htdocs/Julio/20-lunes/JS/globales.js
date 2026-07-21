// Variables de control de estado de la aplicación
var categoriaActual = "vehiculos";
var idSeleccionado = null; 

// Variable global para la instancia del Toast de Bootstrap
var bootstrapToast;

/**
 * Muestra una notificación flotante en pantalla
 * @param {string} mensaje - El texto a mostrar
 * @param {string} tipo - Clase de color de Bootstrap ('success', 'danger', 'warning', 'info')
 */
function mostrarNotificacion(mensaje, tipo = "danger") {
    // 1. Inyectamos el texto en el cuerpo del toast
    $("#toast-mensaje").text(mensaje);
    
    // 2. Limpiamos colores previos y añadimos el color nuevo (ej: bg-success)
    $("#liveToast")
        .removeClass("bg-danger bg-success bg-warning bg-info")
        .addClass("bg-" + tipo);
        
    // 3. Si la instancia ya fue inicializada en main.js, la mostramos
    if (bootstrapToast) {
        bootstrapToast.show();
    } else {
        // Fallback por si acaso se llama antes de que main.js la inicialice
        console.log("Notificación (" + tipo + "): " + mensaje);
    }
}