function cargarMesas(estado = estadoFiltroActual) {
    $.get('./PHP/get_mesas.php', { estado: estado }, function(respuesta) {
        if (respuesta.status === 'success') {
            renderizarMesas(respuesta.mesas);
        } else {
            mostrarToast(respuesta.message || 'Error al cargar las mesas.', false);
        }
    }, 'json').fail(function(error) {
        var msg = error.responseJSON ? error.responseJSON.message : "Error de conexión con el servidor.";
        mostrarToast(msg, false);
    });
}

function cargarBebidas() {
    $.get('./PHP/get_bebidas.php', function(respuesta) {
        if (respuesta.status === 'success') {
            catalogoBebidas = respuesta.bebidas;
            renderizarTarjetasBebidas();
        } else {
            mostrarToast(respuesta.message || 'Error al cargar bebidas.', false);
        }
    }, 'json').fail(function(error) {
        var msg = error.responseJSON ? error.responseJSON.message : "Error al obtener las bebidas.";
        mostrarToast(msg, false);
    });
}

function obtenerTicketMesa(idMesa, callbackExito) {
    $.get('./PHP/get_ticket.php', { id_mesa: idMesa }, function(res) {
        if (res.status === 'success') {
            pedidoActual = res.pedido || [];
            renderizarPedido();
            if (callbackExito) callbackExito();
        } else {
            mostrarToast(res.message, false);
        }
    }, 'json').fail(function(error) {
        var msg = error.responseJSON ? error.responseJSON.message : "Error al consultar el ticket.";
        mostrarToast(msg, false);
    });
}

function guardarTicketMesa() {
    if (modoPagoActivo || !mesaSeleccionada) return;

    var datos = {
        id_mesa: mesaSeleccionada.id,
        bebidas: JSON.stringify(pedidoActual)
    };

    $.post('./PHP/post_ticket_bebidas.php', datos, function(respuesta) {
        if (respuesta.status === 'success') {
            cargarMesas();
        } else {
            mostrarToast(respuesta.message, false);
        }
    }, 'json').fail(function(error) {
        var msg = error.responseJSON ? error.responseJSON.message : "Error al guardar el ticket.";
        mostrarToast(msg, false);
    });
}

function procesarPago(email, $btnConfirmar) {
    $btnConfirmar.prop('disabled', true);

    var datos = {
        id_mesa: mesaSeleccionada.id,
        email: email
    };

    $.post('./PHP/post_pagar.php', datos, function(respuesta) {
        if (respuesta.status === 'success') {
            mesaSeleccionada = null;
            pedidoActual = [];
            modoPagoActivo = false;

            var instance = bootstrap.Modal.getInstance(document.getElementById('modalMesa'));
            if (instance) instance.hide();

            mostrarToast(respuesta.message, true);
            cargarMesas();
        } else {
            mostrarToast(respuesta.message, false);
        }
    }, 'json').fail(function(error) {
        var msg = error.responseJSON ? error.responseJSON.message : "Error al procesar el pago.";
        mostrarToast(msg, false);
    }).always(function() {
        $btnConfirmar.prop('disabled', false);
    });
}