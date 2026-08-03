$(document).ready(function () {
    // 1. Al cargar la app, comprobamos el estado de la sesión
    comprobarEstadoInicial();

    // 2. Evento Submit: Formulario de Login
    $('#formLogin').on('submit', function (e) {
        e.preventDefault();

        const email = $('#loginEmail').val().trim();
        const password = $('#loginPassword').val().trim();

        if (email === '' || password === '') {
            mostrarToast('Por favor, rellena todos los campos.', true);
            return;
        }

        iniciarSesion(email, password)
            .done(function (response) {
                if (response.success) {
                    mostrarToast(response.message, false);
                    $('#modalLogin').modal('hide');
                    $('#formLogin')[0].reset();

                    // Renderizamos interfaz
                    renderizarInterfazUsuario(response.usuario);
                } else {
                    mostrarToast(response.message, true);
                }
            })
            .fail(function () {
                mostrarToast('Error de comunicación con el servidor.', true);
            });
    });

    // 3. Evento Submit: Formulario de Registro
    $('#formRegister').on('submit', function (e) {
        e.preventDefault();

        const nombre = $('#regNombre').val().trim();
        const email = $('#regEmail').val().trim();
        const password = $('#regPassword').val().trim();

        let role = $('#regRole').val();
        if (!$('#containerRoleSelector').hasClass('d-none')) {
            role = $('#regRoleSelect').val();
        }

        if (nombre === '' || email === '' || password === '') {
            mostrarToast('Por favor, completa los campos requeridos.', true);
            return;
        }

        const datosRegistro = { nombre: nombre, email: email, password: password, role: role };

        registrarUsuario(datosRegistro)
            .done(function (response) {
                if (response.success) {
                    mostrarToast(response.message, false);
                    $('#modalRegister').modal('hide');
                    $('#formRegister')[0].reset();
                } else {
                    mostrarToast(response.message, true);
                }
            })
            .fail(function () {
                mostrarToast('Error al procesar el registro.', true);
            });
    });

    // 4. Evento Click: Cerrar Sesión
    $(document).on('click', '#btnLogout', function (e) {
        e.preventDefault();

        cerrarSesion()
            .done(function (response) {
                if (response.success) {
                    mostrarToast(response.message, false);
                    renderizarInterfazInvitado();
                } else {
                    mostrarToast('Error al cerrar sesión.', true);
                }
            })
            .fail(function () {
                mostrarToast('Error de conexión al cerrar sesión.', true);
            });
    });
});

/**
 * Consulta la sesión al servidor e inicializa el UI
 */
function comprobarEstadoInicial() {
    obtenerEstadoSesion()
        .done(function (response) {
            if (response.logged) {
                renderizarInterfazUsuario(response.usuario);
            } else {
                renderizarInterfazInvitado();
            }
        })
        .fail(function () {
            renderizarInterfazInvitado();
        });
}

/**
 * Pinta el header y activa la vista según el usuario y su rol
 */
function renderizarInterfazUsuario(usuario) {
    // UI del Header
    $('#navLoggedOutUI').addClass('d-none');
    $('#navLoggedInUI').removeClass('d-none');

    $('#navUserName').text(usuario.nombre);
    $('#navUserEmail').text(usuario.email);

    let roleBadgeClass = 'bg-info text-dark';
    if (usuario.role === 'admin') roleBadgeClass = 'bg-danger text-white';
    if (usuario.role === 'profesor') roleBadgeClass = 'bg-warning text-dark';

    $('#navUserRoleBadge')
        .attr('class', 'badge ms-1 ' + roleBadgeClass)
        .text(usuario.role.toUpperCase());

    // Enlaces de Navegación por Rol
    const $navLinks = $('#navRoleLinks');
    $navLinks.empty();

    if (usuario.role === 'alumno') {
        $navLinks.append(`
            <li class="nav-item">
                <a class="nav-link active" href="#" id="linkMisAsignaturas"><i class="bi bi-book me-1"></i>Mis Asignaturas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkMisNotas"><i class="bi bi-card-checklist me-1"></i>Exámenes y Notas</a>
            </li>
        `);
    } else if (usuario.role === 'profesor') {
        $navLinks.append(`
            <li class="nav-item">
                <a class="nav-link active" href="#" id="linkMisAlumnos"><i class="bi bi-people me-1"></i>Mis Alumnos</a>
            </li>
        `);
    } else if (usuario.role === 'admin') {
        $navLinks.append(`
            <li class="nav-item">
                <a class="nav-link active" href="#" id="linkGestionUsuarios"><i class="bi bi-person-gear me-1"></i>Gestión Usuarios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkGestionCursos"><i class="bi bi-journal-plus me-1"></i>Cursos y Preguntas</a>
            </li>
        `);
    }

    // Vistas principales (<main>)
    $('main > section').addClass('d-none');

    if (usuario.role === 'alumno') {
        $('#viewAlumno').removeClass('d-none');
        if (typeof cargarDatosAlumno === 'function') cargarDatosAlumno();
    } else if (usuario.role === 'profesor') {
        $('#viewProfesor').removeClass('d-none');
        if (typeof cargarDatosProfesor === 'function') cargarDatosProfesor();
    } else if (usuario.role === 'admin') {
        $('#viewAdmin').removeClass('d-none');
        if (typeof cargarDatosAdmin === 'function') cargarDatosAdmin();
    }
}

/**
 * Resetea el header y muestra la vista pública
 */
function renderizarInterfazInvitado() {
    $('#navLoggedOutUI').removeClass('d-none');
    $('#navLoggedInUI').addClass('d-none');
    $('#navRoleLinks').empty();

    $('main > section').addClass('d-none');
    $('#viewPublic').removeClass('d-none');
}