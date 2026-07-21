// Dibuja las pestañas superiores y decide qué vista cargar en el MAIN
function cargarMenuNavegacion() {
    $.get("PHP/check_session.php", function(usuario) {
        var navIzquierda = $("#nav-izquierda");
        var navDerecha = $("#nav-derecha");
        
        navIzquierda.empty();
        navDerecha.empty();

        if (usuario && usuario.logged) {
            // USUARIO LOGUEADO: Definimos menús de navegación superior
            if (usuario.role === "admin") {
                navIzquierda.append(`
                    <li class="nav-item"><a class="nav-link active" href="#" id="btn-vehiculos">Vehículos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" id="btn-reservas">Reservas</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" id="btn-usuarios">Usuarios</a></li>
                `);
            } else {
                navIzquierda.append(`
                    <li class="nav-item"><a class="nav-link active" href="#" id="btn-vehiculos">Vehículos</a></li>
                    <li class="nav-item"><a class="nav-link" href="#" id="btn-reservas">Reservas</a></li>
                `);
            }

            navDerecha.append(`
                <li class="nav-item d-flex align-items-center text-white me-3">
                    <span>Hola, <strong>${usuario.nombre}</strong></span>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-danger btn-sm" href="#" id="btn-logout">Cerrar Sesión</a>
                </li>
            `);

            // Pintamos la interfaz de administración/usuario con las Cards
            cargarVistaGestion();

        } else {
            // NO LOGUEADO: Menú superior simplificado
            navDerecha.append(`
                <li class="nav-item">
                    <a class="nav-link active" href="#" id="btn-login-nav">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" id="btn-register-nav">Register</a>
                </li>
            `);

            // Por defecto, si no hay login, cargamos el formulario de login directamente en el MAIN
            cargarVistaLogin();
        }
    }, "json").fail(function() {
        console.error("Error al conectar con check_session.php.");
        cargarVistaLogin();
    });
}

// Vista 1: Formulario de Login en el Main
function cargarVistaLogin() {
    var html = `
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm mt-5">
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

// Vista 2: Formulario de Registro en el Main
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

// Vista 3: Estructura del Panel de Control (Formulario + Sección para Cards)
function cargarVistaGestion() {
    var html = `
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h3 id="seccion-titulo" class="mb-0">Lista de Vehículos</h3>
                    <button type="button" class="btn btn-success btn-lg rounded-circle shadow-sm" id="btn-abrir-insertar" aria-label="Añadir nuevo">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
                
                <div class="row row-cols-1 row-cols-md-3 g-4" id="contenedor-cards">
                    <!-- Las Cards se inyectan aquí -->
                </div>
            </div>
        </div>
    `;
    
    // 1. Inyectamos primero el HTML en el contenedor principal
    $("#contenedor-principal").html(html);
    
    // 2. AHORA SÍ, con los elementos ya existentes en el DOM, actualizamos el estado visual
    cambiarCategoria(categoriaActual);
}

function generarCamposModal(categoria) {
    var contenedorCampos = $("#campos-dinamicos-modal");
    contenedorCampos.empty();

    if (categoria === "usuarios") {
        contenedorCampos.append(`
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="input-nombre" name="nombre" placeholder="Nombre completo" required>
                <label for="input-nombre">Nombre completo</label>
            </div>
            <div class="form-floating mb-3">
                <input type="email" class="form-control" id="input-descripcion" name="email" placeholder="correo@ejemplo.com" required>
                <label for="input-descripcion">Correo electrónico</label>
            </div>
            <div class="form-floating mb-3">
                <input type="password" class="form-control" id="input-precio" name="password" placeholder="Contraseña" required>
                <label for="input-precio">Contraseña</label>
            </div>
            <!-- Campo oculto o select si necesitas definir rol en admin -->
            <input type="hidden" id="input-rol" name="role" value="user">
        `);
    } else if (categoria === "reservas") {
        contenedorCampos.append(`
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="input-nombre" name="nombre" placeholder="ID Vehículo o Cliente" required>
                <label for="input-nombre">Identificador de Reserva</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="input-descripcion" name="descripcion" placeholder="Detalles de la reserva" style="height: 6rem; resize: none;" required></textarea>
                <label for="input-descripcion">Detalles / Notas</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" class="form-control" id="input-precio" name="precio" placeholder="Días de duración" required>
                <label for="input-precio">Días totales</label>
            </div>
        `);
    } else { 
        // Por defecto: vehículos
        contenedorCampos.append(`
            <div class="form-floating mb-3">
                <input type="text" class="form-control" id="input-nombre" name="nombre" placeholder="Marca / Modelo" required>
                <label for="input-nombre">Nombre / Modelo</label>
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" id="input-descripcion" name="descripcion" placeholder="Descripción" style="height: 6rem; resize: none;" required></textarea>
                <label for="input-descripcion">Descripción del vehículo</label>
            </div>
            <div class="form-floating mb-3">
                <input type="number" step="0.01" class="form-control" id="input-precio" name="precio" placeholder="Precio por día" required>
                <label for="input-precio">Precio por día (€)</label>
            </div>
        `);
    }
}

// Trae los datos de PHP y los renderiza usando CARDS de Bootstrap en vez de tablas
function mostrarCards(tabla) {
    $.get("PHP/search.php", { tipo: tabla }, function(datos) {
        var contenedor = $("#contenedor-cards");
        contenedor.empty();

        if (datos.length === 0) {
            contenedor.append('<div class="col-12"><p class="text-muted text-center py-4">No hay elementos registrados.</p></div>');
            return;
        }

        datos.forEach(function(item) {
            var cardHTML = `
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0 fw-bold">${item.nombre}</h5>
                                <span class="badge bg-primary fs-6">${item.precio} €/día</span>
                            </div>
                            <p class="card-text text-muted flex-grow-1">${item.descripcion}</p>
                            <div class="d-flex justify-content-end gap-2 mt-3 pt-3 border-top" id="${item.id}">
                                <button type="button" class="btn btn-outline-warning btn-sm btn-editar-card" data-id="${item.id}" data-nombre="${item.nombre}" data-descripcion="${item.descripcion}" data-precio="${item.precio}">
                                    <i class="fa-solid fa-pen-to-square"></i> Editar
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm btn-borrar-card" data-id="${item.id}">
                                    <i class="fa-solid fa-trash"></i> Eliminar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            contenedor.append(cardHTML);
        });
    }, "json").fail(function() {
        console.error("Error al cargar datos de " + tabla);
    });
}

// Actualiza las etiquetas del formulario de gestión al saltar entre Vehículos/Reservas/Usuarios
function cambiarCategoria(categoria) {
    categoriaActual = categoria;
    $(".nav-link").removeClass("active");
    
    // Usamos una comprobación segura por si el elemento no existe en ese milisegundo
    if ($("#input-tipo").length) {
        $("#input-tipo").val(categoria);
    }
    
    if (categoria === "vehiculos") {
        $("#btn-vehiculos").addClass("active");
        $("#seccion-titulo").text("Lista de Vehículos");
    } else if (categoria === "reservas") {
        $("#btn-reservas").addClass("active");
        $("#seccion-titulo").text("Lista de Reservas");
    } else if (categoria === "usuarios") {
        $("#btn-usuarios").addClass("active");
        $("#seccion-titulo").text("Lista de Usuarios");
    }

    mostrarCards(categoria);
}