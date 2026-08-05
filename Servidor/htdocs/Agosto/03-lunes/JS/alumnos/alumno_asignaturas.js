/**
 * Punto de entrada principal invocado desde app.js (renderizarInterfazUsuario)
 */
function cargarDatosAlumno() {
    $('#viewAlumno').removeClass('d-none');
    
    // Renderizamos solo el título de bienvenida
    renderizarEstructuraAlumno();
    
    // Cargar por defecto las asignaturas
    cargarMisAsignaturas();
}

/**
 * Renderiza el encabezado del panel del alumno (sin la botonera duplicada)
 */
function renderizarEstructuraAlumno() {
    const htmlBase = `
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center border-bottom pb-3">
                    <div>
                        <h2 class="fw-bold mb-0 text-primary">
                            <i class="bi bi-mortarboard-fill me-2"></i>Panel del Alumno
                        </h2>
                        <p class="text-muted mb-0 small">Consulta tu avance académico, asignaturas y expediente.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenedor Dinámico para el contenido -->
        <div id="contenedorContenidoAlumno">
            <div class="text-center py-5 text-muted">
                <div class="spinner-border text-primary mb-2" role="status"></div>
                <p>Cargando información...</p>
            </div>
        </div>
    `;

    $('#viewAlumno').html(htmlBase);
}

/**
 * Carga las asignaturas del alumno mediante $.get
 */
function cargarMisAsignaturas() {
    actualizarNavActivo('#linkAlumnoAsignaturas');

    $.get('PHP/alumnos/obtener_asignaturas_alumno.php', function (response) {
        if (response.status === 'success') {
            renderizarAsignaturas(response.actuales, response.pendientes);
        } else {
            mostrarToast(response.message, true);
        }
    }, 'json').fail(function (error) {
        let errorMsg = 'Error al cargar las asignaturas.';
        if (error.responseJSON && error.responseJSON.message) {
            errorMsg = error.responseJSON.message;
        }
        
        $('#contenedorContenidoAlumno').html(`
            <div class="alert alert-warning text-center py-4 my-3" role="alert">
                <i class="bi bi-exclamation-circle-fill fs-3 d-block mb-2 text-warning"></i>
                <h5 class="fw-bold">${errorMsg}</h5>
            </div>
        `);
    });
}

/**
 * Dibuja las tarjetas dentro del contenedor dinámico
 */
function renderizarAsignaturas(actuales, pendientes) {
    let html = '';

    // Si el alumno no tiene asignaturas matriculadas ni pendientes
    if ((!actuales || actuales.length === 0) && (!pendientes || pendientes.length === 0)) {
        html = `
            <div class="text-center py-5 bg-white rounded shadow-sm border my-3">
                <i class="bi bi-journal-x fs-1 text-muted"></i>
                <h4 class="mt-3 text-secondary">Actualmente no tienes asignaturas matriculadas</h4>
                <p class="text-muted mb-0">Si crees que esto es un error, ponte en contacto con administración.</p>
            </div>
        `;
        $('#contenedorContenidoAlumno').html(html);
        return;
    }

    // 1. Curso Actual
    html += `<h4 class="text-secondary border-bottom pb-2 mb-3"><i class="bi bi-journal-check me-2"></i>Curso Actual</h4>`;
    if (!actuales || actuales.length === 0) {
        html += `<div class="alert alert-info"><i class="bi bi-info-circle me-2"></i>No tienes asignaturas matriculadas en el curso actual.</div>`;
    } else {
        html += `<div class="row row-cols-1 row-cols-md-3 g-4 mb-5">`;
        actuales.forEach(asig => {
            html += crearTarjetaAsignatura(asig, 'border-primary');
        });
        html += `</div>`;
    }

    // 2. Asignaturas Pendientes
    if (pendientes && pendientes.length > 0) {
        html += `<h4 class="text-danger border-bottom pb-2 mb-3"><i class="bi bi-exclamation-triangle-fill me-2"></i>Asignaturas Pendientes</h4>`;
        html += `<div class="row row-cols-1 row-cols-md-3 g-4 mb-4">`;
        pendientes.forEach(asig => {
            html += crearTarjetaAsignatura(asig, 'border-danger');
        });
        html += `</div>`;
    }

    $('#contenedorContenidoAlumno').html(html);
}

/**
 * Genera el HTML de la tarjeta de asignatura
 */
function crearTarjetaAsignatura(asig, borderClass) {
    return `
        <div class="col">
            <div class="card h-100 shadow-sm ${borderClass} card-asignatura" style="cursor: pointer;" 
                 data-nombre="${asig.asignatura_nombre}"
                 data-curso="${asig.curso_nombre}"
                 data-ano="${asig.ano_academico}"
                 data-aula="Aula ${asig.aula_id}"
                 data-estado="${asig.estado}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title text-dark fw-bold mb-0">${asig.asignatura_nombre}</h5>
                        <span class="badge ${asig.estado === 'cursando' ? 'bg-primary' : 'bg-danger'}">${asig.estado}</span>
                    </div>
                    <p class="card-text text-muted mb-1"><i class="bi bi-building me-1"></i>${asig.curso_nombre}</p>
                    <small class="text-secondary"><i class="bi bi-door-open me-1"></i>Aula ${asig.aula_id}</small>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <span class="btn btn-sm btn-outline-primary"><i class="bi bi-eye me-1"></i>Ver Detalle</span>
                </div>
            </div>
        </div>
    `;
}

/**
 * Carga la sección de Mis Exámenes
 */
function cargarMisExamenes() {
    actualizarNavActivo('#linkAlumnoExamenes');
    $('#contenedorContenidoAlumno').html(`
        <div class="alert alert-secondary py-4 text-center">
            <i class="bi bi-tools fs-2 d-block mb-2"></i>
            <h5>Módulo de Exámenes en construcción...</h5>
        </div>
    `);
}

/**
 * Carga el Histórico / Expediente
 */
function cargarHistorico() {
    actualizarNavActivo('#linkAlumnoExpediente');
    $('#contenedorContenidoAlumno').html(`
        <div class="alert alert-secondary py-4 text-center">
            <i class="bi bi-tools fs-2 d-block mb-2"></i>
            <h5>Módulo del Histórico / Expediente en construcción...</h5>
        </div>
    `);
}

/**
 * Cambia la clase 'active' en el menú Navbar principal
 */
function actualizarNavActivo(selectorLink) {
    $('#navRoleLinks .nav-link').removeClass('active');
    $(selectorLink).addClass('active');
}

/* ==========================================================================
   EVENTOS DELEGADOS (NAVBAR Y TARJETAS)
   ========================================================================== */

// Evento: Abrir Modal al hacer clic en una tarjeta de asignatura
$(document).on('click', '.card-asignatura', function () {
    const nombre = $(this).data('nombre');
    const curso = $(this).data('curso');
    const ano = $(this).data('ano');
    const aula = $(this).data('aula');
    const estado = $(this).data('estado');

    $('#detalleNombreAsignatura').text(nombre);
    $('#detalleCursoNombre').text(curso);
    $('#detalleAnoAcademico').text(ano);
    $('#detalleAula').text(aula);
    $('#detalleEstado').text(String(estado).toUpperCase());

    const modalDetalle = new bootstrap.Modal(document.getElementById('modalDetalleAsignatura'));
    modalDetalle.show();
});

// Eventos: Clics en la Navbar Superior
$(document).on('click', '#linkAlumnoAsignaturas', function (e) {
    e.preventDefault();
    cargarMisAsignaturas();
});

$(document).on('click', '#linkAlumnoExamenes', function (e) {
    e.preventDefault();
    cargarMisExamenes();
});

$(document).on('click', '#linkAlumnoExpediente', function (e) {
    e.preventDefault();
    cargarHistorico();
});