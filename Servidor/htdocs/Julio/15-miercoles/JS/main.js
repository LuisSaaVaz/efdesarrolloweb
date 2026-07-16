$(document).ready(function() {
    
    // Inicializar la app mostrando bebidas por defecto al cargar
    mostrar("bebidas");

    // Manejadores de los botones de navegación de la barra superior
    $("#btn-bebidas").on("click", function(e) {
        e.preventDefault();
        cambiarCategoria("bebidas");
    });

    $("#btn-postres").on("click", function(e) {
        e.preventDefault();
        cambiarCategoria("postres");
    });

    // Evento submit del formulario de registro (Crear nuevo elemento)
    $(".mi-formulario").on("submit", function(e) {
        e.preventDefault();

        var nombreVal = $("#input-nombre").val().trim();
        var descVal = $("#input-descripcion").val().trim();
        var precioOriginal = $("#input-precio").val().trim();

        if (nombreVal === "" || descVal === "") {
            mostrarNotificacion("Por favor, rellena todos los campos de texto.", "warning");
            return;
        }

        var precioProcesado = precioOriginal.replace(",", ".");
        var precioNum = parseFloat(precioProcesado);

        if (isNaN(precioNum) || precioNum <= 0) {
            mostrarNotificacion("El precio debe ser un número válido y mayor que 0.", "danger");
            return;
        }

        var tipoVal = $("#input-tipo").val(); 
        var formulario = $(this);

        var datosAEnviar = {
            tipo: tipoVal,
            nombre: nombreVal,
            descripcion: descVal,
            precio: precioProcesado
        };

        $.post("PHP/register.php", datosAEnviar, function(respuesta) {
            mostrarNotificacion(respuesta, "success");
            formulario[0].reset();
            mostrar(categoriaActual);
        }).fail(function(error) {
            var mensajeError = error.responseText || "Ocurrió un error al enviar los datos al servidor.";
            mostrarNotificacion(mensajeError, "danger");
        });
    });

    // ==========================================
    //  LÓGICA DE EDICIÓN (Delegación de eventos)
    // ==========================================
    $("#tabla-body").on("click", ".editar", function() {
        idSeleccionado = $(this).parent().attr("id");
        
        var fila = $(this).closest("tr");
        var nombreActual = fila.find("td").eq(1).text();
        var descripcionActual = fila.find("td").eq(2).text();
        var precioActual = fila.find("td").eq(3).text().replace("€", "").trim();

        $("#edit-id").val(idSeleccionado);
        $("#edit-nombre").val(nombreActual);
        $("#edit-descripcion").val(descripcionActual);
        $("#edit-precio").val(precioActual);

        var tituloSingular = categoriaActual === "bebidas" ? "Bebida" : "Postre";
        $("#modalEditarTitulo").text("Editar " + tituloSingular);

        modalEditarBS.show();
    });

    // Confirmación y envío de datos editados
    $("#form-editar").on("submit", function(e) {
        e.preventDefault();

        var nombreVal = $("#edit-nombre").val().trim();
        var descVal = $("#edit-descripcion").val().trim();
        var precioOriginal = $("#edit-precio").val().trim();

        if (nombreVal === "" || descVal === "") {
            mostrarNotificacion("Por favor, rellena todos los campos de texto.", "warning");
            return;
        }

        var precioProcesado = precioOriginal.replace(",", ".");
        var precioNum = parseFloat(precioProcesado);

        if (isNaN(precioNum) || precioNum <= 0) {
            mostrarNotificacion("El precio debe ser un número válido y mayor que 0.", "danger");
            return;
        }

        var datosAEnviar = {
            id: $("#edit-id").val(),
            tipo: categoriaActual,
            nombre: nombreVal,
            descripcion: descVal,
            precio: precioProcesado
        };

        $.post("PHP/update.php", datosAEnviar, function(respuesta) {
            mostrarNotificacion(respuesta, "success");
            modalEditarBS.hide();
            mostrar(categoriaActual);
        }).fail(function(error) {
            var mensajeError = error.responseText || "No se pudieron actualizar los datos.";
            mostrarNotificacion(mensajeError, "danger");
        });
    });

    // ==========================================
    //  LÓGICA DE BORRADO (Delegación de eventos)
    // ==========================================
    $("#tabla-body").on("click", ".borrar", function() {
        idSeleccionado = $(this).parent().attr("id");
        modalBorrarBS.show();
    });

    // Confirmación final del borrado en el modal
    $("#btn-confirmar-borrar").on("click", function() {
        var datosAEnviar = {
            id: idSeleccionado,
            tipo: categoriaActual
        };

        $.post("PHP/delete.php", datosAEnviar, function(respuesta) {
            mostrarNotificacion(respuesta, "success");
            modalBorrarBS.hide();
            mostrar(categoriaActual);
        }).fail(function(error) {
            var mensajeError = error.responseText || "No se pudo eliminar el elemento.";
            mostrarNotificacion(mensajeError, "danger");
        });
    });

});