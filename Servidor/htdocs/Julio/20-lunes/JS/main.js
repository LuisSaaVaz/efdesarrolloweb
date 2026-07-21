$(document).ready(function() {
    
    // Arrancar la aplicación comprobando el estado de la sesión
    cargarMenuNavegacion();

    // Función auxiliar para cerrar el menú desplegable en móviles usando jQuery
    function cerrarMenuMovil() {
        var $menu = $("#navbarNav");
        
        // Comprobamos si el menú está abierto (Bootstrap le añade la clase 'show')
        if ($menu.hasClass("show")) {
            // Obtenemos la instancia de Bootstrap pasando el elemento nativo desde jQuery [$menu[0]]
            var bsCollapse = bootstrap.Collapse.getInstance($menu[0]);
            if (!bsCollapse) {
                bsCollapse = new bootstrap.Collapse($menu[0]);
            }
            bsCollapse.hide();
        }
    }

    // Evento para cambiar a la vista de Login desde el Navbar
    $(document).on("click", "#btn-login-nav", function(e) {
        e.preventDefault(); 
        
        // Estilo visual activo
        $("#btn-register-nav").removeClass("active");
        $(this).addClass("active");
        
        cargarVistaLogin();
        cerrarMenuMovil(); // <-- Cierra el desplegable
    });

    // Evento para cambiar a la vista de Registro desde el Navbar
    $(document).on("click", "#btn-register-nav", function(e) {
        e.preventDefault();
        
        // Estilo visual activo
        $("#btn-login-nav").removeClass("active");
        $(this).addClass("active");
        
        cargarVistaRegister();
        cerrarMenuMovil(); // <-- Cierra el desplegable
    });

    // --- PROCESAR FORMULARIO DE REGISTRO PÚBLICO ---
    $(document).on("submit", "#form-register", function(e) {
        e.preventDefault();

        var nombreVal = $("#register-nombre").val().trim();
        var emailVal = $("#register-email").val().trim();
        var passwordVal = $("#register-password").val().trim();

        // Petición AJAX al archivo que acabamos de crear
        $.post("PHP/register_user.php", {
            nombre: nombreVal,
            email: emailVal,
            password: passwordVal
        }, function(respuesta) {
            // Usamos la función global de notificaciones
            mostrarNotificacion(respuesta, "success");
            
            // Redirigir visualmente al Login para que pueda entrar
            cargarVistaLogin();
            $("#btn-register-nav").removeClass("active");
            $("#btn-login-nav").addClass("active");
        }).fail(function(error) {
            var mensajeError = error.responseText || "Error en el registro.";
            mostrarNotificacion(mensajeError, "danger");
        });
    });
});