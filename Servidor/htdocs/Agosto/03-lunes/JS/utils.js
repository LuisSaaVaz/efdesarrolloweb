/**
 * Muestra un mensaje flotante utilizando el Toast de Bootstrap.
 * @param {string} mensaje - Texto a mostrar.
 * @param {boolean} esError - Si es true se pinta rojo (danger), si es false verde (success).
 */
function mostrarToast(mensaje, esError = false) {
	const $toastEl = $('#liveToast');

	if ($toastEl.length) {
		$('#toastBody').text(mensaje);

		if (esError) {
			$toastEl
				.removeClass('bg-success text-white')
				.addClass('bg-danger text-white');
		} else {
			$toastEl
				.removeClass('bg-danger text-white')
				.addClass('bg-success text-white');
		}

		const toast = bootstrap.Toast.getOrCreateInstance($toastEl[0]);
		toast.show();
	} else {
		console.log((esError ? '[ERROR] ' : '[OK] ') + mensaje);
	}
}

/**
 * Abre y configura el modal genérico reutilizable
 * @param {Object} opciones { titulo, icono, headerClass, tamano, cuerpoHtml, footerHtml }
 */
function abrirModalGenerico({
	titulo,
	icono = 'bi-info-circle',
	headerClass = 'bg-primary',
	tamano = '',
	cuerpoHtml = '',
	footerHtml = '',
}) {
	// 1. Configurar Header
	$('#modalGenericoHeader').attr(
		'class',
		`modal-header text-white ${headerClass}`,
	);
	$('#modalGenericoTitulo').html(`<i class="bi ${icono} me-2"></i>${titulo}`);

	// 2. Configurar Tamaño ('modal-lg', 'modal-xl', '' para normal)
	$('#modalGenericoTamaño').attr(
		'class',
		`modal-dialog modal-dialog-centered ${tamano}`,
	);

	// 3. Inyectar Cuerpo y Footer
	$('#modalGenericoCuerpo').html(cuerpoHtml);

	if (footerHtml) {
		$('#modalGenericoFooter').html(footerHtml).show();
	} else {
		$('#modalGenericoFooter')
			.html(
				'<button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Cerrar</button>',
			)
			.show();
	}

	// 4. Mostrar el Modal
	const modalInstance = bootstrap.Modal.getOrCreateInstance(
		document.getElementById('modalGenerico'),
	);
	modalInstance.show();
}
