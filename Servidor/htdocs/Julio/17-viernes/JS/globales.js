// Variables globales de estado de la aplicación
var categoriaActual = "vehiculos";
var idSeleccionado = null; 

// Declaramos las variables de Bootstrap sin inicializarlas directamente
var bootstrapToast;

// Variable para los modales
var modalGestionBS;

// Utilidad para avisos emergentes interactivos (Toasts)
function mostrarNotificacion(mensaje, tipo = "danger") {
    $("#toast-mensaje").text(mensaje);
    $("#liveToast").removeClass("bg-danger bg-success bg-warning").addClass("bg-" + tipo);
    if (bootstrapToast) {
        bootstrapToast.show();
    }
}