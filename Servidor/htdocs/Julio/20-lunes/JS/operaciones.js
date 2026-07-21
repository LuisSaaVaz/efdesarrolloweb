// Comprueba si hay sesión activa en el servidor y pinta la interfaz adecuada
function cargarMenuNavegacion() {
    $.get("PHP/check_session.php", function(usuario) {
        var navIzquierda = $("#nav-izquierda");
        var navDerecha = $("#nav-derecha");
        
        // Limpiamos los menús por seguridad antes de pintar
        navIzquierda.empty();
        navDerecha.empty();

        if (usuario && usuario.logged) {
            // [PASO FUTURO]: Aquí gestionaremos el menú del usuario logueado
            $("#contenedor-principal").html(`<h2 class="text-center">¡Bienvenido, ${usuario.nombre}! (Panel de Gestión)</h2>`);
        } else {
            // NO LOGUEADO: Pintamos los botones públicos en la derecha
            navDerecha.append(`
                <li class="nav-item">
                    <a class="nav-link active" href="" id="btn-login-nav">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="" id="btn-register-nav">Registro</a>
                </li>
            `);

            // Por defecto, cargamos el formulario de login en el contenedor principal
            cargarVistaLogin();
        }
    }, "json").fail(function() {
        console.error("Error al conectar con check_session.php. Levantando entorno seguro de Login.");
        cargarVistaLogin();
    });
}

// Inyecta el formulario de Iniciar Sesión en el contenedor principal
function cargarVistaLogin() {
    var html = `
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm mt-4">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>
                        <form id="form-login">
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="login-email" name="email" placeholder="name@example.com" required>
                                <label for="login-email">Correo electrónico</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="login-password" name="password" placeholder="Contraseña" required>
                                <label for="login-password">Contraseña</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;
    $("#contenedor-principal").html(html);
}

// Inyecta el formulario de Registro en el contenedor principal
function cargarVistaRegister() {
    var html = `
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm mt-5">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Crear Cuenta</h3>
                        <form id="form-registro-directo">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="reg-nombre" name="nombre" placeholder="Tu nombre" required>
                                <label for="reg-nombre">Nombre de usuario</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="reg-email" name="email" placeholder="name@example.com" required>
                                <label for="reg-email">Correo electrónico</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="reg-password" name="password" placeholder="Contraseña" required>
                                <label for="reg-password">Contraseña</label>
                            </div>
                            <button type="submit" class="btn btn-success w-100 py-2">Registrarse</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    `;
    $("#contenedor-principal").html(html);
}