// JS/app.js

// Estado Global de la Aplicación
var mesaSeleccionada = null;
var pedidoActual = [];
var catalogoBebidas = [];
var modoPagoActivo = false;
var estadoFiltroActual = 'todas'; // Almacena el filtro activo ('todas', 'libre', 'ocupada')

$(document).ready(function() {

    // -----------------------------------------------------------------
    // INICIALIZACIÓN Y FILTROS
    // -----------------------------------------------------------------
    
    // Carga inicial pasando el filtro por defecto
    cargarMesas(estadoFiltroActual);

    // Botón manual de recargar (mantiene el filtro actual)
    $('#btn-recargar').click(function() {
        cargarMesas(estadoFiltroActual);
    });

    // EVENTO: Cambio de Filtro de Mesas (Todas / Libre / Ocupada)
    $(document).on('click', '.filtro-mesa', function() {
        // Actualizar resalte visual del filtro seleccionado
        $('.filtro-mesa').removeClass('activo border border-2 border-dark');
        $(this).addClass('activo border border-2 border-dark');

        // Capturar el nuevo estado y consultar la API
        estadoFiltroActual = $(this).data('estado');
        cargarMesas(estadoFiltroActual);
    });

    // -----------------------------------------------------------------
    // GESTIÓN DE MESAS Y TICKET
    // -----------------------------------------------------------------

    // 1. ABRIR MESA AL HACER CLIC EN SU TARJETA
    $(document).on('click', '.card-mesa', function() {
        mesaSeleccionada = {
            id: $(this).data('id'),
            numero: $(this).data('numero'),
            estado: $(this).data('estado')
        };

        $('#titulo-modal-mesa').text('Mesa ' + mesaSeleccionada.numero);
        activarModoCatalogo();

        // Cargar bebidas solo si no han sido cargadas previamente
        if (catalogoBebidas.length === 0) {
            cargarBebidas();
        }

        // Obtener ticket de la mesa y mostrar el modal
        obtenerTicketMesa(mesaSeleccionada.id, function() {
            var modal = new bootstrap.Modal(document.getElementById('modalMesa'));
            modal.show();
        });
    });

    // 2. AÑADIR BEBIDA AL TICKET ACTUAL
    $(document).on('click', '.btn-agregar-bebida', function() {
        if (modoPagoActivo) return;

        var id = parseInt($(this).data('id'), 10);
        var nombre = $(this).data('nombre');
        var precio = parseFloat($(this).data('precio'));

        var existente = pedidoActual.find(item => parseInt(item.id_bebida, 10) === id);

        if (existente) {
            existente.cantidad += 1;
        } else {
            pedidoActual.push({
                id_bebida: id,
                nombre: nombre,
                precio: precio,
                cantidad: 1
            });
        }

        renderizarPedido();
    });

    // 3. RESTAR O ELIMINAR BEBIDA DEL TICKET
    $(document).on('click', '.btn-restar', function() {
        if (modoPagoActivo) return;

        var id = parseInt($(this).data('id'), 10);
        var index = pedidoActual.findIndex(item => parseInt(item.id_bebida, 10) === id);

        if (index !== -1) {
            if (pedidoActual[index].cantidad > 1) {
                pedidoActual[index].cantidad -= 1;
            } else {
                pedidoActual.splice(index, 1);
            }
        }

        renderizarPedido();
    });

    // 4. GUARDAR CAMBIOS DE TICKET AL CERRAR EL MODAL
    $('#modalMesa').on('hide.bs.modal', function () {
        guardarTicketMesa();
    });

    // -----------------------------------------------------------------
    // PROCESO DE PAGO
    // -----------------------------------------------------------------

    // Iniciar flujo de pago desde el modal
    $('#btn-pagar').click(function() {
        if (pedidoActual.length === 0) {
            mostrarToast("No hay consumiciones para cobrar en esta mesa.", false);
            return;
        }
        activarModoPago();
    });

    // Cancelar flujo de pago y volver al catálogo
    $('#btn-cancelar-pago').click(function() {
        activarModoCatalogo();
    });

    // Confirmar y procesar el pago
    $('#btn-confirmar-pago').click(function() {
        var email = $('#email-cliente').val().trim();
        var regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (email !== "" && !regexEmail.test(email)) {
            mostrarToast("Introduce un formato de correo electrónico válido.", false);
            $('#email-cliente').focus();
            return;
        }

        procesarPago(email, $(this));
    });
});