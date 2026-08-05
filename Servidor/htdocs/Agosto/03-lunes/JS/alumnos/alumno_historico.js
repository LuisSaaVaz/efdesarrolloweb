/**
 * Carga el módulo de Histórico / Expediente
 */
function cargarHistorico() {
    actualizarNavActivo('#linkAlumnoExpediente');

    $('#contenedorContenidoAlumno').html(`
        <div class="text-center py-5 text-muted">
            <div class="spinner-border text-primary mb-2" role="status"></div>
            <p>Cargando histórico de exámenes...</p>
        </div>
    `);

    solicitarHistorico({});
}

/**
 * Realiza la petición $.get al servidor con los filtros especificados
 */
function solicitarHistorico(filtros) {
    $.get('php/alumnos/obtener_historico_alumno.php', filtros, function (response) {
        if (response.status === 'success') {
            if ($('#formFiltrosHistorico').length === 0) {
                renderizarFormularioFiltros(response.filtros);
                inyectarmodalDetalleHistorico();
            } else {
                // Actualizamos los selects según la jerarquía de filtros activa
                actualizarOpcionesFiltros(response.filtros);
            }
            renderizarHistoricoResponsive(response.historico);
        } else {
            mostrarToast(response.message, true);
        }
    }, 'json').fail(function (error) {
        let errorMsg = 'Error al cargar el histórico.';
        if (error.responseJSON && error.responseJSON.message) {
            errorMsg = error.responseJSON.message;
        }
        $('#contenedorContenidoAlumno').html(`
            <div class="alert alert-danger" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>${errorMsg}
            </div>
        `);
    });
}

/**
 * Pinta la estructura inicial del formulario de filtros
 */
function renderizarFormularioFiltros(opciones) {
    const html = `
        <div class="card shadow-sm mb-4 border-0 bg-light">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title text-secondary mb-0"><i class="bi bi-funnel me-2"></i>Filtrar Expediente</h5>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="btnLimpiarFiltrosHistorico">
                        <i class="bi bi-x-circle me-1"></i>Limpiar Filtros
                    </button>
                </div>
                <form id="formFiltrosHistorico" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Año Académico</label>
                        <select class="form-select form-select-sm filtro-auto" id="filtroAno"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Curso</label>
                        <select class="form-select form-select-sm filtro-auto" id="filtroCurso"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Asignatura</label>
                        <select class="form-select form-select-sm filtro-auto" id="filtroAsignatura"></select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small text-muted">Resultado</label>
                        <select class="form-select form-select-sm filtro-auto" id="filtroResultado">
                            <option value="">Todos</option>
                            <option value="aprobado">Aprobados (>= 5.0)</option>
                            <option value="suspenso">Suspensos (< 5.0)</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <div id="contenedorTablaHistorico"></div>
    `;

    $('#contenedorContenidoAlumno').html(html);
    actualizarOpcionesFiltros(opciones);
}

/**
 * Rellena/Actualiza los selects de Cursos y Asignaturas (con agrupamiento por optgroup)
 */
function actualizarOpcionesFiltros(opciones) {
    const valAnoSel = $('#filtroAno').val();
    const valCursoSel = $('#filtroCurso').val();
    const valAsigSel = $('#filtroAsignatura').val();

    // 1. Años
    if ($('#filtroAno option').length === 0) {
        let selectAnos = '<option value="">Todos los años</option>';
        opciones.anos.forEach(a => selectAnos += `<option value="${a.id}">${a.nombre}</option>`);
        $('#filtroAno').html(selectAnos);
    }

    // 2. Cursos
    let selectCursos = '<option value="">Todos los cursos</option>';
    opciones.cursos.forEach(c => selectCursos += `<option value="${c.id}">${c.nombre}</option>`);
    $('#filtroCurso').html(selectCursos).val(valCursoSel || "");

    // 3. Asignaturas (Agrupadas por Curso usando <optgroup>)
    let selectAsig = '<option value="">Todas las asignaturas</option>';

    if (opciones.asignaturas.length > 0) {
        // Agrupar asignaturas por curso
        const asignaturasPorCurso = {};
        opciones.asignaturas.forEach(as => {
            if (!asignaturasPorCurso[as.curso_nombre]) {
                asignaturasPorCurso[as.curso_nombre] = [];
            }
            asignaturasPorCurso[as.curso_nombre].push(as);
        });

        // Si solo hay un curso (o filtramos por curso), no saturamos con optgroups innecesarios
        const keysCursos = Object.keys(asignaturasPorCurso);
        if (keysCursos.length === 1 && valCursoSel) {
            asignaturasPorCurso[keysCursos[0]].forEach(as => {
                selectAsig += `<option value="${as.id}">${as.nombre}</option>`;
            });
        } else {
            // Generar los optgroups por cada curso
            for (const [cursoNombre, listaAsig] of Object.entries(asignaturasPorCurso)) {
                selectAsig += `<optgroup label="${cursoNombre}">`;
                listaAsig.forEach(as => {
                    selectAsig += `<option value="${as.id}">${as.nombre}</option>`;
                });
                selectAsig += `</optgroup>`;
            }
        }
    }

    $('#filtroAsignatura').html(selectAsig).val(valAsigSel || "");
}

/**
 * Renderiza la vista de escritorio y móvil
 */
function renderizarHistoricoResponsive(historico) {
    if (!historico || historico.length === 0) {
        $('#contenedorTablaHistorico').html(`
            <div class="text-center py-5 bg-white rounded shadow-sm border my-2">
                <i class="bi bi-inbox fs-1 text-muted"></i>
                <h5 class="mt-2 text-secondary">No se encontraron registros de exámenes</h5>
                <p class="text-muted small mb-0">Prueba a cambiar los filtros seleccionados.</p>
            </div>
        `);
        return;
    }

    let filasTabla = '';
    let cardsMovil = '';

    historico.forEach(item => {
        const nota = parseFloat(item.nota);
        const badgeNotaClass = nota >= 5.0 ? 'bg-success' : 'bg-danger';

        const fechaFormateada = new Date(item.fecha_inicio).toLocaleDateString('es-ES', {
            year: 'numeric', month: 'short', day: 'numeric', hour: '2-digit', minute: '2-digit'
        });

        const jsonString = JSON.stringify(item).replace(/"/g, '&quot;');

        filasTabla += `
            <tr>
                <td><span class="badge bg-light text-dark border">${item.ano_academico}</span></td>
                <td class="fw-bold text-secondary">${item.asignatura_nombre}</td>
                <td>${item.examen_titulo}</td>
                <td><span class="badge ${badgeNotaClass} fs-6">${nota.toFixed(2)}</span></td>
                <td class="text-end">
                    <button class="btn btn-sm btn-outline-primary btn-ver-detalle-examen" data-detalle="${jsonString}">
                        <i class="bi bi-eye me-1"></i>Detalle
                    </button>
                </td>
            </tr>
        `;

        cardsMovil += `
            <div class="card mb-3 shadow-sm border-start border-4 ${nota >= 5.0 ? 'border-success' : 'border-danger'}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge bg-light text-dark border mb-1">${item.ano_academico}</span>
                            <h6 class="fw-bold mb-0 text-dark">${item.asignatura_nombre}</h6>
                        </div>
                        <span class="badge ${badgeNotaClass} fs-5">${nota.toFixed(2)}</span>
                    </div>
                    <p class="text-muted small mb-2"><i class="bi bi-journal-text me-1"></i>${item.examen_titulo}</p>
                    <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top">
                        <small class="text-muted"><i class="bi bi-calendar-event me-1"></i>${fechaFormateada}</small>
                        <button class="btn btn-sm btn-primary btn-ver-detalle-examen" data-detalle="${jsonString}">
                            <i class="bi bi-eye me-1"></i>Ver más
                        </button>
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
                        <th>Año Lectivo</th>
                        <th>Asignatura</th>
                        <th>Examen</th>
                        <th>Nota</th>
                        <th class="text-end">Acción</th>
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

    $('#contenedorTablaHistorico').html(htmlFinal);
}

/**
 * Inyecta el modal dinámico de detalle si no existe
 */
function inyectarmodalDetalleHistorico() {
    if ($('#modalDetalleExamen').length === 0) {
        const modalHtml = `
            <div class="modal fade" id="modalDetalleExamen" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title fw-bold">
                                <i class="bi bi-file-earmark-text me-2"></i>Detalle del Examen
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="text-center mb-4 p-3 bg-light rounded border">
                                <small class="text-muted text-uppercase fw-bold d-block mb-1">Calificación Obtenida</small>
                                <span id="modalExamenNota" class="display-4 fw-bold">0.00</span>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-book me-2"></i>Asignatura:</span>
                                    <strong id="modalExamenAsignatura">-</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-journal-check me-2"></i>Examen:</span>
                                    <strong id="modalExamenTitulo">-</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-building me-2"></i>Curso:</span>
                                    <strong id="modalExamenCurso">-</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-calendar3 me-2"></i>Año Académico:</span>
                                    <strong id="modalExamenAno">-</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-clock me-2"></i>Tiempo Empleado:</span>
                                    <strong id="modalExamenTiempo">-</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-info-circle me-2"></i>Estado:</span>
                                    <strong id="modalExamenEstado">-</strong>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span class="text-muted"><i class="bi bi-calendar-check me-2"></i>Fecha Realización:</span>
                                    <strong id="modalExamenFecha">-</strong>
                                </li>
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHtml);
    }
}

/* ==========================================================================
   EVENTOS
   ========================================================================== */

// Evento Change: Actualización automática al cambiar cualquier filtro
$(document).on('change', '.filtro-auto', function () {
    // Si cambia el año, reseteamos las asignaturas para evitar incompatibilidades
    if ($(this).attr('id') === 'filtroAno') {
        $('#filtroAsignatura').val('');
    }

    const filtros = {
        ano_id: $('#filtroAno').val(),
        curso_id: $('#filtroCurso').val(),
        asig_id: $('#filtroAsignatura').val(),
        resultado: $('#filtroResultado').val()
    };

    solicitarHistorico(filtros);
});

// Evento Click: Limpiar Filtros
$(document).on('click', '#btnLimpiarFiltrosHistorico', function () {
    $('#filtroAno').val('');
    $('#filtroCurso').val('');
    $('#filtroAsignatura').val('');
    $('#filtroResultado').val('');
    solicitarHistorico({});
});

// Evento Click: Abrir Modal Detalle
$(document).on('click', '.btn-ver-detalle-examen', function () {
    const item = $(this).data('detalle');

    const nota = parseFloat(item.nota);
    const mins = Math.floor(item.tiempo_empleado_segundos / 60);
    const segs = item.tiempo_empleado_segundos % 60;
    const tiempoTexto = `${mins}m ${segs}s (Límite: ${item.duracion_minutos}m)`;

    const fechaFormateada = new Date(item.fecha_inicio).toLocaleDateString('es-ES', {
        year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit'
    });

    $('#modalExamenNota')
        .text(nota.toFixed(2))
        .removeClass('text-success text-danger')
        .addClass(nota >= 5.0 ? 'text-success' : 'text-danger');

    $('#modalExamenAsignatura').text(item.asignatura_nombre);
    $('#modalExamenTitulo').text(item.examen_titulo);
    $('#modalExamenCurso').text(item.curso_nombre);
    $('#modalExamenAno').text(item.ano_academico);
    $('#modalExamenTiempo').text(tiempoTexto);
    $('#modalExamenEstado').text(item.estado.toUpperCase());
    $('#modalExamenFecha').text(fechaFormateada);

    const modal = new bootstrap.Modal(document.getElementById('modalDetalleExamen'));
    modal.show();
});