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

    function register() {
        // Sincronizar botones del NAV
        $('#show-login').removeClass('btn-light').addClass('btn-outline-light');
        $('#show-register').removeClass('btn-outline-light').addClass('btn-light');

        var registerForm = `
            <div class="card p-4 shadow d-flex flex-column gap-4" style="width: 350px;">
                <div id="form-register">
                    <h2 class="text-center text-primary m-0">Register</h2>
                    <form class="d-flex flex-column gap-2" action="register.php" method="POST">
                        <div class="form-floating">
                            <input type="text" name="nombre" class="form-control" id="floatingInput" placeholder="Nombre"
                                required>
                            <label for="floatingInput">Nombre</label>
                        </div>
                        <div class="form-floating">
                            <input type="text" name="apellidos" class="form-control" id="floatingInput"
                                placeholder="Apellidos" required>
                            <label for="floatingInput">Apellidos</label>
                        </div>
                        <div class="form-floating">
                            <input type="number" name="edad" class="form-control" id="floatingInput" placeholder="Edad"
                                required>
                            <label for="floatingInput">Edad</label>
                        </div>
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control" id="floatingInput"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="floatingPassword"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating">
                            <input type="date" name="fecha_nacimiento" class="form-control" id="floatingPassword"
                                placeholder="Fecha de nacimiento" required>
                            <label for="floatingPassword">Fecha de nacimiento</label>
                        </div>
                        <div class="form-floating">
                            <select class="form-select form-select-sm" aria-label="Small select example">
                                <option selected>Elige una opción</option>
                                <option value="1">Masculino</option>
                                <option value="2">Femenino</option>
                                <option value="3">Otro</option>
                            </select>
                            <label for="floatingPassword">Sexo</label>
                        </div>
                        <button type="submit" name="btn_add_user" class="btn btn-primary w-100">Add</button>
                    </form>
                </div>
            </div>
        `;

        $("main").html(registerForm);
    }

    function login() {
        // Sincronizar botones del NAV
        $('#show-register').removeClass('btn-light').addClass('btn-outline-light');
        $('#show-login').removeClass('btn-outline-light').addClass('btn-light');

        var loginForm = `
            <div class="card p-4 shadow d-flex flex-column gap-4" style="width: 350px;">
                <div id="form-login">
                    <h2 class="text-center text-primary m-0">Login</h2>
                    <form class="d-flex flex-column gap-2" action="login.php" action="login.php" method="POST">
                        <div class="form-floating">
                            <input type="email" name="email" class="form-control" id="floatingInput"
                                placeholder="name@example.com" required>
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating">
                            <input type="password" name="password" class="form-control" id="floatingPassword"
                                placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                        </div>
                        <button type="submit" name="btn_login" class="btn btn-primary w-100">Login</button>
                    </form>
                    <p class="text-center mt-2">¿No tienes cuenta? <a href="" id="go-register">Registro</a></p>
                </div>
            </div>
        `;

        $("main").html(loginForm);
    }


	// Eventos de los botones del NAV
	$('#show-login').click(function (e) {
		e.preventDefault();
		login();
	});

	$('#show-register').click(function (e) {
		e.preventDefault();
        register();
	});

	// Evento del enlace dentro del formulario
	$('#go-register').click(function (e) {
		e.preventDefault();
		register();
	});
});
