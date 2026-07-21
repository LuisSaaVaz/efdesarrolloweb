$(document).ready(function() {
    
    // Inicializar instancias de componentes de Bootstrap 5
    bootstrapToast = new bootstrap.Toast($("#liveToast"));
    modalGestionBS = new bootstrap.Modal($("#modalGestion"));

    // Arrancar la aplicación leyendo el estado de la sesión y pintando la interfaz adecuada
    cargarMenuNavegacion();

    // ==========================================
    // 1. EVENTOS DEL MENÚ DE NAVEGACIÓN SUPERIOR
    // ==========================================

    // Pestañas de gestión (Izquierda) - Usan delegación por si cambian según el rol
    $("#nav-izquierda").on("click", "#btn-vehiculos", function(e) {
        e.preventDefault();
        cambiarCategoria("vehiculos");
    });

    $("#nav-izquierda").on("click", "#btn-reservas", function(e) {
        e.preventDefault();
        cambiarCategoria("reservas");
    });

    $("#nav-izquierda").on("click", "#btn-usuarios", function(e) {
        e.preventDefault();
        cambiarCategoria("usuarios");
    });

    // Pestañas de acceso (Derecha) - Intercambio de formularios en el Main (Sin Modales)
    $("#nav-derecha").on("click", "#btn-login-nav", function(e) {
        e.preventDefault();
        $(".nav-link").removeClass("active");
        $(this).addClass("active");
        cargarVistaLogin();
    });

    $("#nav-derecha").on("click", "#btn-register-nav", function(e) {
        e.preventDefault();
        $(".nav-link").removeClass("active");
        $(this).addClass("active");
        cargarVistaRegister();
    });

    // Cerrar sesión
    $("#nav-derecha").on("click", "#btn-logout", function(e) {
        e.preventDefault();
        $.post("PHP/logout.php", function(respuesta) {
            mostrarNotificacion(respuesta, "warning");
            categoriaActual = "vehiculos"; // Reseteamos la categoría por defecto
            cargarMenuNavegacion(); // Redibuja el entorno público
        });
    });


    // ==========================================
    // 2. FORMULARIOS DE AUTENTICACIÓN (EN EL MAIN)
    // ==========================================

    // Procesar el envío del Login
    $(document).on("submit", "#form-login", function(e) {
        e.preventDefault();

        var emailVal = $("#login-email").val().trim();
        var passVal = $("#login-password").val().trim();

        $.post("PHP/login.php", { email: emailVal, password: passVal }, function(respuesta) {
            mostrarNotificacion(respuesta, "success");
            
            // Forzamos categoría limpia antes de pintar el panel de control
            categoriaActual = "vehiculos"; 
            cargarMenuNavegacion(); 
        }).fail(function(error) {
            var mensajeError = error.responseText || "Error al iniciar sesión.";
            mostrarNotificacion(mensajeError, "danger");
        });
    });

    // Procesar el envío del Registro Público
    $(document).on("submit", "#form-registro-directo", function(e) {
        e.preventDefault();

        var nombreVal = $("#reg-nombre").val().trim();
        var emailVal = $("#reg-email").val().trim();
        var passVal = $("#reg-password").val().trim();

        $.post("PHP/register_user.php", { nombre: nombreVal, email: emailVal, password: passVal }, function(respuesta) {
            mostrarNotificacion(respuesta, "success");
            
            // Redirección visual inmediata al Login tras registrarse con éxito
            cargarVistaLogin();
            $("#btn-register-nav").removeClass("active");
            $("#btn-login-nav").addClass("active");
        }).fail(function(error) {
            var mensajeError = error.responseText || "Error al registrar usuario.";
            mostrarNotificacion(mensajeError, "danger");
        });
    });


    // ==========================================
    // 3. ACCIONES DEL MODAL DE GESTIÓN (CRUD)
    // ==========================================

    // Botón "+" junto al H3: Abre el modal listo para INSERTAR
    $(document).on("click", "#btn-abrir-insertar", function() {
        // Configurar metadatos del modal
        $("#gestion-action").val("insertar");
        $("#gestion-id").val("");
        $("#input-tipo").val(categoriaActual);
        $("#modalGestionTitulo").text("Añadir nuevo registro a " + categoriaActual);
        
        // Estilo de botón e inyección de campos según la pestaña actual
        $("#btn-submit").removeClass("btn-warning text-white").addClass("btn-primary").text("Guardar");
        generarCamposModal(categoriaActual);
        
        // Resetear inputs previos y levantar modal
        $("#form-gestion")[0].reset();
        modalGestionBS.show();
    });

    // Botón "Editar" en una Card: Abre el modal listo para ACTUALIZAR
    $(document).on("click", ".btn-editar-card", function() {
        var id = $(this).attr("data-id");
        var nombre = $(this).attr("data-nombre");
        var descripcion = $(this).attr("data-descripcion");
        var precio = $(this).attr("data-precio");

        // Configurar metadatos del modal
        $("#gestion-action").val("editar");
        $("#gestion-id").val(id);
        $("#input-tipo").val(categoriaActual);
        $("#modalGestionTitulo").text("Editar elemento de " + categoriaActual + " (ID: " + id + ")");
        
        // Ajustar aspecto al modo edición
        $("#btn-submit").removeClass("btn-primary").addClass("btn-warning text-white").text("Actualizar Cambios");

        // Inyectar campos dinámicos y rellenar con sus datos actuales
        generarCamposModal(categoriaActual);
        $("#input-nombre").val(nombre);
        $("#input-descripcion").val(descripcion);
        $("#input-precio").val(precio);

        // Excepción visual de seguridad si editamos usuarios (bloquear campos clave)
        if (categoriaActual === "usuarios") {
            $("#input-descripcion").prop("disabled", true); // Email bloqueado
            $("#input-precio").attr("type", "text").val("********").prop("disabled", true); // Password oculta
        }

        modalGestionBS.show();
    });

    // Procesar el envío unificado del Formulario del Modal (Insertar / Editar)
    $(document).on("submit", "#form-gestion", function(e) {
        e.preventDefault();

        var action = $("#gestion-action").val();
        var tipoVal = $("#input-tipo").val(); 

        var nombreVal = $("#input-nombre").val().trim();
        var descVal = $("#input-descripcion").val().trim();
        var precioOriginal = $("#input-precio").val().trim();

        // Limpieza básica de decimales
        var precioProcesado = precioOriginal.replace(",", ".");

        // Enrutamiento dinámico hacia el controlador PHP adecuado
        var urlDestino = (action === "editar") ? "PHP/update.php" : "PHP/register.php";
        
        // Si el administrador inserta un usuario nuevo a través del panel de control
        if (tipoVal === "usuarios" && action === "insertar") {
            urlDestino = "PHP/register_user.php";
        }

        // Construcción del objeto de datos POST estándar
        var datosEnviar = {
            tipo: tipoVal,
            nombre: nombreVal,
            descripcion: descVal,
            precio: precioProcesado
        };

        // Adjuntar ID si estamos modificando un registro existente
        if (action === "editar") {
            datosEnviar.id = $("#gestion-id").val();
        }

        // Remapear variables si es inserción de un usuario por administrador
        if (tipoVal === "usuarios" && action === "insertar") {
            datosEnviar.email = descVal;          // El campo descripción actúa como email en la plantilla
            datosEnviar.password = precioOriginal; // El campo precio actúa como contraseña en la plantilla
            datosEnviar.role = $("#input-rol").val() || "user";
        }

        // Envío asíncrono
        $.post(urlDestino, datosEnviar, function(respuesta) {
            mostrarNotificacion(respuesta, "success");
            modalGestionBS.hide(); // Ocultar ventana emergente
            $("#form-gestion")[0].reset();
            mostrarCards(categoriaActual); // Refrescar el grid de fondo sin recargar la página
        }).fail(function(error) {
            var mensajeError = error.responseText || "Error al procesar la solicitud.";
            mostrarNotificacion(mensajeError, "danger");
        });
    });

    // Botón "Eliminar" en una Card
    $(document).on("click", ".btn-borrar-card", function() {
        var id = $(this).attr("data-id");
        
        if (confirm("¿Estás seguro de que deseas eliminar este elemento de forma permanente?")) {
            $.post("PHP/delete.php", { id: id, tipo: categoriaActual }, function(respuesta) {
                mostrarNotificacion(respuesta, "success");
                mostrarCards(categoriaActual); // Refrescar vista de tarjetas
            }).fail(function(error) {
                var mensajeError = error.responseText || "No se pudo completar la eliminación.";
                mostrarNotificacion(mensajeError, "danger");
            });
        }
    });

});