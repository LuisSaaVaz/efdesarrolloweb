// Muestra mensajes flotantes (Toast)
function mostrarToast(mensaje, esExito) {
    var $toast = $('#toast-mensaje');
    $toast.removeClass('bg-success bg-danger').addClass(esExito ? 'bg-success' : 'bg-danger');
    $('#toast-texto').text(mensaje || 'Ocurrió un error inesperado.');
    new bootstrap.Toast($toast[0]).show();
}

// Activa la vista de catálogo en el modal
function activarModoCatalogo() {
    modoPagoActivo = false;
    $('#titulo-seccion-izquierda').html('<i class="fa-solid fa-wine-glass me-1 text-primary"></i> Catálogo de Bebidas');
    $('#vista-formulario-pago').addClass('d-none');
    $('#vista-catalogo').removeClass('d-none');
    $('#contenedor-accion-pago').addClass('d-none');
    $('#contenedor-accion-normal').removeClass('d-none');
    $('#email-cliente').val('');
}

// Activa la vista de formulario de pago en el modal
function activarModoPago() {
    modoPagoActivo = true;
    $('#titulo-seccion-izquierda').html('<i class="fa-solid fa-credit-card me-1 text-success"></i> Procesar Pago');
    $('#vista-catalogo').addClass('d-none');
    $('#vista-formulario-pago').removeClass('d-none');
    $('#contenedor-accion-normal').addClass('d-none');
    $('#contenedor-accion-pago').removeClass('d-none');
    $('#email-cliente').focus();
}

// Renderiza las tarjetas de mesas en la cuadrícula principal
function renderizarMesas(mesas) {
    var $contenedor = $('#contenedor-mesas').empty();

    if (!mesas || mesas.length === 0) {
        $contenedor.html('<div class="col-12 text-center text-muted">No hay mesas registradas.</div>');
        return;
    }

    $.each(mesas, function(i, mesa) {
        var tarjetaHTML = `
            <div class="col">
                <div class="card card-mesa mesa-tarjeta ${mesa.estado} text-center h-100 p-2" 
                     data-id="${mesa.id_mesa}" 
                     data-numero="${mesa.numero_mesa}"
                     data-estado="${mesa.estado}">
                    <div class="card-body d-flex flex-column justify-content-between align-items-center">
                        <span class="badge badge-estado ${mesa.estado} align-self-end text-capitalize px-2 py-1">
                            ${mesa.estado}
                        </span>
                        <i class="fa-solid fa-utensils icono-mesa fa-3x my-2"></i>
                        <h5 class="card-title fw-bold mb-0">Mesa ${mesa.numero_mesa}</h5>
                    </div>
                </div>
            </div>`;
        $contenedor.append(tarjetaHTML);
    });
}

// Renderiza los elementos del catálogo de bebidas
function renderizarTarjetasBebidas() {
    var $contenedorBebidas = $('#contenedor-bebidas').empty();
    $.each(catalogoBebidas, function(i, bebida) {
        var fotoUrl = bebida.foto || 'https://via.placeholder.com/150';
        var tarjetaBebida = `
            <div class="col">
                <div class="card card-bebida h-100 shadow-sm btn-agregar-bebida" 
                     data-id="${bebida.id_bebida}"
                     data-nombre="${bebida.nombre}"
                     data-precio="${bebida.precio}">
                    <img src="${fotoUrl}" class="card-img-top img-bebida" alt="${bebida.nombre}">
                    <div class="card-body p-1 text-center">
                        <h6 class="card-title fs-7 fw-bold mb-1 text-truncate">${bebida.nombre}</h6>
                        <span class="badge bg-primary">${parseFloat(bebida.precio).toFixed(2)} €</span>
                    </div>
                </div>
            </div>`;
        $contenedorBebidas.append(tarjetaBebida);
    });
}

// Renderiza la lista del ticket actual de la mesa
function renderizarPedido() {
    var $lista = $('#lista-pedido').empty();
    var total = 0;

    if (pedidoActual.length === 0) {
        $lista.html('<li class="list-group-item text-center text-muted py-3">No hay consumiciones añadidas.</li>');
        $('#total-pedido').text('0.00 €');
        return;
    }

    $.each(pedidoActual, function(i, item) {
        var subtotal = item.precio * item.cantidad;
        total += subtotal;

        var itemHTML = `
            <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                <div class="lh-1 me-1 text-truncate">
                    <span class="fw-bold fs-7 text-truncate d-block">${item.nombre}</span>
                    <small class="text-muted fs-8">${parseFloat(item.precio).toFixed(2)} € x ${item.cantidad}</small>
                </div>
                <div class="d-flex align-items-center gap-1 flex-shrink-0">
                    <span class="badge bg-secondary rounded-pill">x${item.cantidad}</span>
                    <span class="fw-bold text-dark fs-7 me-1">${subtotal.toFixed(2)} €</span>
                    <button class="btn btn-sm btn-outline-danger p-1 py-0 btn-restar" data-id="${item.id_bebida}">
                        <i class="fa-solid fa-minus fs-8"></i>
                    </button>
                </div>
            </li>`;
        $lista.append(itemHTML);
    });

    $('#total-pedido').text(total.toFixed(2) + ' €');
}