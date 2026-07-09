$(document).ready(function () {
	// Función centralizada para cambiar el formulario y el estilo de los botones
	function cambiarVista(vista) {
		if (vista === 'login') {
			$('#form-register').addClass('d-none');
			$('#form-login').removeClass('d-none');

			// Sincronizar botones del NAV
			$('#show-register')
				.removeClass('btn-light')
				.addClass('btn-outline-light');
			$('#show-login').removeClass('btn-outline-light').addClass('btn-light');
		} else {
			$('#form-login').addClass('d-none');
			$('#form-register').removeClass('d-none');

			// Sincronizar botones del NAV
			$('#show-login').removeClass('btn-light').addClass('btn-outline-light');
			$('#show-register')
				.removeClass('btn-outline-light')
				.addClass('btn-light');
		}
	}

	// Eventos de los botones del NAV
	$('#show-login').click(function (e) {
		e.preventDefault();
		cambiarVista('login');
	});

	$('#show-register').click(function (e) {
		e.preventDefault();
		cambiarVista('register');
	});

	// Evento del enlace dentro del formulario
	$('#go-register').click(function (e) {
		e.preventDefault();
		cambiarVista('register');
	});
});
