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
		const fechaNac = $('#regFechaNac').val(); // Devuelve YYYY-MM-DD
		const password = $('#regPassword').val().trim();

		// Si el contenedor está visible (is(':visible')), leemos el select; si no, forzamos 'alumno'
		let role = 'alumno';
		if ($('#containerRoleSelector').is(':visible')) {
			role = $('#regRoleSelect').val();
		}

		if (!nombre || !email || !fechaNac || !password) {
			mostrarToast('Por favor, completa todos los campos requeridos.', true);
			return;
		}

		const datosRegistro = {
			nombre: nombre,
			email: email,
			fecha_nacimiento: fechaNac,
			password: password,
			role: role,
		};

		// LLAMADA A $.post MEDIANTE LA PROMESA .done() Y .fail()
		registrarUsuario(datosRegistro)
			.done(function (response) {
				if (response.success) {
					mostrarToast(response.message, false); // Muestra toast VERDE de éxito
					$('#modalRegister').modal('hide');
					$('#formRegister')[0].reset();
				} else {
					mostrarToast(response.message, true); // Muestra toast ROJO si el email ya existe
				}
			})
			.fail(function () {
				mostrarToast(
					'Error de comunicación al intentar registrar el usuario.',
					true,
				);
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
 * @param {Object} usuario - Datos devueltos por la sesión PHP
 */
function renderizarInterfazUsuario(usuario) {
	// 1. UI del Header (Datos Básicos)
	$('#navLoggedOutUI').addClass('d-none');
	$('#navLoggedInUI').removeClass('d-none');

	$('#navUserName').text(usuario.nombre);
	$('#navUserEmail').text(usuario.email);

	// Color del Badge de Rol
	let roleBadgeClass = 'bg-info text-dark';
	if (usuario.role === 'admin') roleBadgeClass = 'bg-danger text-white';
	if (usuario.role === 'profesor') roleBadgeClass = 'bg-warning text-dark';

	$('#navUserRoleBadge')
		.attr('class', 'badge ms-1 ' + roleBadgeClass)
		.text(usuario.role.toUpperCase());

	// 2. Generación Dinámica de Enlaces de Navegación
	const $navLinks = $('#navRoleLinks');
	$navLinks.empty();

	if (usuario.role === 'alumno') {
		$navLinks.append(`
            <li class="nav-item">
                <a class="nav-link active" href="#" id="linkAlumnoAsignaturas"><i class="bi bi-book me-1"></i>Mis Asignaturas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkAlumnoExamenes"><i class="bi bi-pencil-square me-1"></i>Mis Exámenes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkAlumnoExpediente"><i class="bi bi-clock-history me-1"></i></i>Histórico / Expediente</a>
            </li>
        `);
	} else if (usuario.role === 'profesor') {
		$navLinks.append(`
            <li class="nav-item">
                <a class="nav-link active" href="#" id="linkProfesorClases"><i class="bi bi-easel me-1"></i>Mis Clases y Alumnos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkProfesorExamenes"><i class="bi bi-file-earmark-text me-1"></i>Gestión de Exámenes</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkProfesorHistorico"><i class="bi bi-clock-history me-1"></i>Histórico Docente</a>
            </li>
        `);
	} else if (usuario.role === 'admin') {
		$navLinks.append(`
            <li class="nav-item">
                <a class="nav-link active" href="#" id="linkAdminUsuarios"><i class="bi bi-person-gear me-1"></i>Usuarios y Matriculaciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkAdminEstructura"><i class="bi bi-diagram-3 me-1"></i>Cursos, Aulas y Asignaturas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkAdminAnos"><i class="bi bi-calendar-range me-1"></i>Años Académicos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" id="linkAdminExamenes"><i class="bi bi-journal-plus me-1"></i>Exámenes y Preguntas</a>
            </li>
        `);
	}

	// 3. Activación de Secciones Principales en el HTML (<main>)
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
