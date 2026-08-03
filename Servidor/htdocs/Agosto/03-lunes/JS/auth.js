/**
 * Realiza la petición para iniciar sesión
 */
function iniciarSesion(email, password) {
    return $.post('php/login.php', { email: email, password: password }, null, 'json');
}

/**
 * Realiza la petición para registrar un usuario
 */
function registrarUsuario(datosUsuario) {
    return $.post('php/register.php', datosUsuario, null, 'json');
}

/**
 * Realiza la petición para cerrar la sesión activa
 */
function cerrarSesion() {
    return $.get('php/logout.php', null, null, 'json');
}

/**
 * Consulta la sesión en el servidor
 */
function obtenerEstadoSesion() {
    return $.get('php/check_session.php', null, null, 'json');
}