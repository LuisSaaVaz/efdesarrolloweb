/**
 * Punto de entrada principal invocado al logearse como Admin
 */
function cargarDatosAdmin() {
	$('#viewAdmin').removeClass('d-none');

	// 1. Renderiza la estructura base del panel Admin (<div id="contenedorContenidoAdmin">)
	renderizarEstructuraAdmin();

	// 2. Carga por defecto la pestaña de Usuarios y Matriculaciones
	cargarGestionUsuarios();
}

/**
 * Renderiza el encabezado del panel del Admin y su contenedor principal
 */
function renderizarEstructuraAdmin() {
	const htmlBase = `
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                    <div>
                        <h2 class="fw-bold mb-0 text-primary">
                            <i class="bi bi-shield-lock-fill me-2"></i>Panel de Administración
                        </h2>
                        <p class="text-muted mb-0 small">Gestión general de usuarios, matriculaciones, asignaturas y configuraciones del sistema.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenedor Dinámico para los submódulos del Admin -->
        <div id="contenedorContenidoAdmin"></div>
    `;

	$('#viewAdmin').html(htmlBase);
}

/**
 * Carga el módulo de Usuarios y Matriculaciones
 */
function cargarGestionUsuarios() {
	actualizarNavAdminActivo('#linkAdminUsuarios');

	// Renderizamos de inmediato el formulario de filtros y la estructura vacía de la tabla
	renderizarFormularioFiltrosUsuarios();

	// Colocamos el spinner dentro del contenedor de la tabla mientras AJAX responde
	$('#contenedorTablaUsuarios').html(`
        <div class="text-center py-5 text-muted">
            <div class="spinner-border text-primary mb-2" role="status"></div>
            <p>Cargando lista de usuarios...</p>
        </div>
    `);

	// Solicitamos los datos
	solicitarUsuariosAdmin({});
}

/**
 * Petición AJAX al servidor para obtener la lista de usuarios
 */
function solicitarUsuariosAdmin(filtros) {
	$.get(
		'PHP/admins/obtener_usuarios.php',
		filtros,
		function (response) {
			if (response.status === 'success') {
				// Renderizamos las filas/tarjetas dentro de #contenedorTablaUsuarios (que ya existe)
				renderizarTablaUsuarios(response.usuarios);
			} else {
				mostrarToast(response.message, true);
			}
		},
		'json',
	).fail(function (error) {
		let errorMsg = 'Error al cargar los usuarios.';
		if (error.responseJSON && error.responseJSON.message) {
			errorMsg = error.responseJSON.message;
		}
		$('#contenedorTablaUsuarios').html(`
            <div class="alert alert-danger my-3" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>${errorMsg}
            </div>
        `);
	});
}

/**
 * Renderiza el formulario de filtros y prepara el contenedor de la tabla
 */
function renderizarFormularioFiltrosUsuarios() {
	const html = `
        <div class="card shadow-sm mb-4 border-0 bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-secondary mb-0"><i class="bi bi-funnel me-2"></i>Filtrar Usuarios</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnLimpiarFiltrosUsuarios">
                        <i class="bi bi-x-circle me-1"></i>Limpiar Filtros
                    </button>
                </div>
                <form id="formFiltrosUsuarios" class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label small text-muted">Buscar por Nombre / Email</label>
                        <input type="text" class="form-control form-control-sm" id="filtroTextoUsuario" placeholder="Escribe para buscar...">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small text-muted">Filtrar por Rol</label>
                        <select class="form-select form-select-sm" id="filtroRolUsuario">
                            <option value="">Todos los roles</option>
                            <option value="alumno">Alumnos</option>
                            <option value="profesor">Profesores</option>
                            <option value="admin">Administradores</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Año Nacimiento</label>
                        <input type="number" class="form-control form-control-sm" id="filtroAnioNacimiento" placeholder="Ej: 2005" min="1900" max="2099">
                    </div>
                </form>
            </div>
        </div>

        <!-- Este contenedor DEBE existir antes de llamar a renderizarTablaUsuarios -->
        <div id="contenedorTablaUsuarios"></div>
    `;

	$('#contenedorContenidoAdmin').html(html);
}

/**
 * Renderiza la tabla de usuarios (Escritorio) y tarjetas (Móvil)
 */
function renderizarTablaUsuarios(usuarios) {
	if (!usuarios || usuarios.length === 0) {
		$('#contenedorTablaUsuarios').html(`
            <div class="text-center py-5 bg-white rounded shadow-sm border my-2">
                <i class="bi bi-person-x fs-1 text-muted"></i>
                <h5 class="mt-2 text-secondary">No se encontraron usuarios</h5>
                <p class="text-muted small mb-0">Prueba ajustando los criterios de búsqueda.</p>
            </div>
        `);
		return;
	}

	let filasTabla = '';
	let cardsMovil = '';

	usuarios.forEach((user) => {
		const jsonUser = JSON.stringify(user).replace(/"/g, '&quot;');

		let badgeRol = '';
		let botonAccion = '';

		if (user.role === 'alumno') {
			badgeRol = `<span class="badge bg-primary"><i class="bi bi-person-badge me-1"></i>Alumno</span>`;
			botonAccion = `
                <button class="btn btn-sm btn-outline-primary btn-gestion-matricula" data-user="${jsonUser}">
                    <i class="bi bi-journal-plus me-1"></i>Matrícula
                </button>
            `;
		} else if (user.role === 'profesor') {
			badgeRol = `<span class="badge bg-success"><i class="bi bi-award me-1"></i>Profesor</span>`;
			botonAccion = `
                <button class="btn btn-sm btn-outline-success btn-gestion-asignar" data-user="${jsonUser}">
                    <i class="bi bi-journal-check me-1"></i>Asignar
                </button>
            `;
		} else if (user.role === 'admin') {
			badgeRol = `<span class="badge bg-danger"><i class="bi bi-shield-lock me-1"></i>Admin</span>`;
			botonAccion = `<span class="text-muted small fs-7"><i class="bi bi-dash-circle me-1"></i>Sin acciones</span>`;
		}

		// Fila Escritorio
		filasTabla += `
            <tr>
                <td class="fw-bold text-dark">${user.nombre}</td>
                <td class="text-muted">${user.email}</td>
                <td>${badgeRol}</td>
                <td class="text-end">${botonAccion}</td>
            </tr>
        `;

		// Tarjeta Móvil
		cardsMovil += `
            <div class="card mb-3 shadow-sm border-0">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <h6 class="fw-bold mb-0 text-dark">${user.nombre}</h6>
                            <small class="text-muted">${user.email}</small>
                        </div>
                        ${badgeRol}
                    </div>
                    <div class="text-end mt-3 pt-2 border-top">
                        ${botonAccion}
                    </div>
                </div>
            </div>
        `;
	});

	const htmlFinal = `
        <div class="table-responsive bg-white rounded shadow-sm border d-none d-md-block">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th class="text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    ${filasTabla}
                </tbody>
            </table>
        </div>

        <div class="d-block d-md-none">
            ${cardsMovil}
        </div>
    `;

	$('#contenedorTablaUsuarios').html(htmlFinal);
}

/**
 * Actualiza el estado activo de la Navbar del Admin y cierra el menú desplegable en móvil
 */
function actualizarNavAdminActivo(selectorLink) {
	$('#navRoleLinks .nav-link').removeClass('active');
	$(selectorLink).addClass('active');

	const navbarCollapse = document.getElementById('navbarNav');
	if (navbarCollapse && navbarCollapse.classList.contains('show')) {
		const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
		if (bsCollapse) bsCollapse.hide();
	}
}

/* ==========================================================================
   1. GESTIÓN DE EVENTOS DE LA NAVBAR DE ADMINISTRACIÓN
   ========================================================================== */

// Clic en "Usuarios y Matriculaciones"
$(document).on('click', '#linkAdminUsuarios', function (e) {
	e.preventDefault();
	cargarGestionUsuarios();
});

// Clic en "Cursos, Aulas y Asignaturas"
$(document).on('click', '#linkAdminEstructura', function (e) {
	e.preventDefault();
	actualizarNavAdminActivo('#linkAdminEstructura');
	$('#contenedorContenidoAdmin').html(`
        <div class="alert alert-info py-4">
            <h5><i class="bi bi-diagram-3 me-2"></i>Módulo de Cursos, Aulas y Asignaturas</h5>
            <p class="mb-0">Próximamente podrás gestionar el catálogo académico desde aquí.</p>
        </div>
    `);
});

// Clic en "Años Académicos"
$(document).on('click', '#linkAdminAnos', function (e) {
	e.preventDefault();
	actualizarNavAdminActivo('#linkAdminAnos');
	$('#contenedorContenidoAdmin').html(`
        <div class="alert alert-info py-4">
            <h5><i class="bi bi-calendar-range me-2"></i>Módulo de Años Académicos</h5>
            <p class="mb-0">Próximamente podrás aperturar y gestionar cursos escolares.</p>
        </div>
    `);
});

// Clic en "Exámenes y Preguntas"
$(document).on('click', '#linkAdminExamenes', function (e) {
	e.preventDefault();
	actualizarNavAdminActivo('#linkAdminExamenes');
	$('#contenedorContenidoAdmin').html(`
        <div class="alert alert-info py-4">
            <h5><i class="bi bi-journal-plus me-2"></i>Módulo Global de Exámenes</h5>
            <p class="mb-0">Próximamente podrás consultar y supervisar todos los exámenes del sistema.</p>
        </div>
    `);
});

/* ==========================================================================
   2. FILTROS Y EVENTOS DEL MÓDULO DE USUARIOS
   ========================================================================== */

// Evento: Filtrado en tiempo real
$(document).on(
	'input change',
	'#filtroTextoUsuario, #filtroRolUsuario, #filtroAnioNacimiento',
	function () {
		const filtros = {
			busqueda: $('#filtroTextoUsuario').val(),
			rol: $('#filtroRolUsuario').val(),
			anio_nacimiento: $('#filtroAnioNacimiento').val(),
		};
		solicitarUsuariosAdmin(filtros);
	},
);

// Evento: Limpiar Filtros
$(document).on('click', '#btnLimpiarFiltrosUsuarios', function () {
	$('#filtroTextoUsuario').val('');
	$('#filtroRolUsuario').val('');
	$('#filtroAnioNacimiento').val('');
	solicitarUsuariosAdmin({});
});

/* ==========================================================================
   3. MODALES DINÁMICOS
   ========================================================================== */

// Botón Matrícula (Alumnos)
$(document).on('click', '.btn-gestion-matricula', function () {
	const usuario = $(this).data('user');

	const cuerpoHtml = `
        <div class="p-2">
            <div class="alert alert-info py-2 mb-3">
                <i class="bi bi-person-fill me-1"></i> <strong>Alumno:</strong> ${usuario.nombre} (${usuario.email})
            </div>
            <p class="small text-muted mb-3">Selecciona el curso académico y las asignaturas en las que deseas matricular a este alumno.</p>

            <div id="cuerpoMatriculaDinamico">
                <div class="text-center py-3">
                    <div class="spinner-border spinner-border-sm text-primary"></div>
                    <span class="ms-2">Cargando asignaturas disponibles...</span>
                </div>
            </div>
        </div>
    `;

	const footerHtml = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnGuardarMatricula" data-userid="${usuario.id}">
            <i class="bi bi-check-circle me-1"></i>Guardar Matriculación
        </button>
    `;

	abrirModalGenerico({
		titulo: `Gestión de Matrícula`,
		icono: 'bi-journal-plus',
		headerClass: 'bg-primary',
		tamano: 'modal-lg',
		cuerpoHtml: cuerpoHtml,
		footerHtml: footerHtml,
	});

	$.get(
		'php/admins/obtener_opciones_matricula.php',
		{ usuario_id: usuario.id },
		function (res) {
			if (res.status === 'success') {
				$('#cuerpoMatriculaDinamico').html(`
                <div class="mb-3">
                    <label class="form-label fw-bold">Asignaturas Disponibles</label>
                    <div class="border rounded p-3 bg-light">
                        <p class="text-muted small mb-0">Listado cargado correctamente.</p>
                    </div>
                </div>
            `);
			}
		},
		'json',
	).fail(function () {
		$('#cuerpoMatriculaDinamico').html(`
            <div class="alert alert-warning py-2 small mb-0">
                <i class="bi bi-exclamation-triangle me-1"></i> Carga preliminar (Endpoint PHP de matriculación en desarrollo).
            </div>
        `);
	});
});

// Botón Asignar (Profesores)
$(document).on('click', '.btn-gestion-asignar', function () {
	const usuario = $(this).data('user');

	const cuerpoHtml = `
        <div class="p-2">
            <div class="alert alert-success py-2 mb-3">
                <i class="bi bi-person-badge-fill me-1"></i> <strong>Profesor:</strong> ${usuario.nombre} (${usuario.email})
            </div>
            <p class="small text-muted mb-3">Selecciona las asignaturas que serán impartidas por este docente.</p>

            <div id="cuerpoAsignacionDinamico">
                <div class="text-center py-3">
                    <div class="spinner-border spinner-border-sm text-success"></div>
                    <span class="ms-2">Cargando asignaturas del profesor...</span>
                </div>
            </div>
        </div>
    `;

	const footerHtml = `
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-success" id="btnGuardarAsignacionProfesor" data-userid="${usuario.id}">
            <i class="bi bi-check-circle me-1"></i>Guardar Asignaciones
        </button>
    `;

	abrirModalGenerico({
		titulo: `Asignación de Materias a Profesor`,
		icono: 'bi-journal-check',
		headerClass: 'bg-success',
		tamano: 'modal-lg',
		cuerpoHtml: cuerpoHtml,
		footerHtml: footerHtml,
	});

	$.get(
		'php/admins/obtener_opciones_profesor.php',
		{ usuario_id: usuario.id },
		function (res) {
			if (res.status === 'success') {
				$('#cuerpoAsignacionDinamico').html(`
                <p class="text-muted small mb-0">Carga de asignaturas completada.</p>
            `);
			}
		},
		'json',
	).fail(function () {
		$('#cuerpoAsignacionDinamico').html(`
            <div class="alert alert-warning py-2 small mb-0">
                <i class="bi bi-exclamation-triangle me-1"></i> Carga preliminar (Endpoint PHP de profesor en desarrollo).
            </div>
        `);
	});
});
