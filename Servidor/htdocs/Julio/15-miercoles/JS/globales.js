// Variables globales de estado compartidas
var categoriaActual = "bebidas";
var idSeleccionado = null; 

// Inicializar elementos de Bootstrap
var toastElement = $("#liveToast");
var bootstrapToast = new bootstrap.Toast(toastElement);

var modalEditarBS = new bootstrap.Modal($("#modalEditar"));
var modalBorrarBS = new bootstrap.Modal($("#modalBorrar"));

// Función reutilizable para mostrar notificaciones con estilo Bootstrap
function mostrarNotificacion(mensaje, tipo = "danger") {
    $("#toast-mensaje").text(mensaje);
    
    // Limpiar clases de color previas y aplicar la correspondiente (bg-danger, bg-success, etc.)
    $("#liveToast").removeClass("bg-danger bg-success bg-warning").addClass("bg-" + tipo);
    
    bootstrapToast.show();
}