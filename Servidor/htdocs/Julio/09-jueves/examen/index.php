<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Bootsatrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <?php include 'nav.php'; ?>
    </header>
    <main class="container d-flex justify-content-center align-items-center">
        <?php if (!isset($_SESSION['logged'])): ?>
        <div class="card p-4 shadow d-flex flex-column gap-4" style="width: 350px;">
            <div id="form-login">
                <h2 class="text-center text-primary m-0">Login</h2>
                <form class="d-flex flex-column gap-2" action="login.php" method="POST">
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
        <?php endif; ?>
    </main>

    <div class="modal fade" id="modalEditar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form id="formEditar" action="actualizar.php" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Usuario</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="edit-id">
                    <input type="text" name="nombre" id="edit-nombre" class="form-control mb-2">
                    <input type="text" name="apellidos" id="edit-apellidos" class="form-control mb-2">
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modalBorrar" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">¿Estás seguro de que deseas borrar este usuario?</div>
                <div class="modal-footer">
                    <a href="#" id="btnConfirmarBorrar" class="btn btn-danger">Confirmar Borrar</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous">
    </script>

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Scripts -->
    <script src="./toggleLogReg.js"></script>
    <script src="./edBorr.js"></script>

    <?php 
        // 1. Cargar la tabla siempre que haya sesión
        if (isset($_SESSION['logged'])) {
            include 'consultar.php';
        }

        // 2. Mostrar mensaje de confirmación si existe el parámetro 'msg'
        if (isset($_GET['msg']) && !empty($_GET['msg'])) {
            $mensaje = htmlspecialchars($_GET['msg']);
            echo "
            <div class='modal fade' id='modalMensaje' tabindex='-1'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h5 class='modal-title'>Notificación</h5>
                            <button type='button' class='btn-close' data-bs-dismiss='modal'></button>
                        </div>
                        <div class='modal-body'>
                            <p>$mensaje</p>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(document).ready(function() {
                    var modalEl = document.getElementById('modalMensaje');
                    var myModal = new bootstrap.Modal(modalEl);
                    myModal.show();

                    // Limpiar la URL al cerrar el modal
                    modalEl.addEventListener('hidden.bs.modal', function () {
                        const cleanUrl = window.location.pathname;
                        window.history.replaceState({}, document.title, cleanUrl);
                    });
                });
            </script>";
        }
    ?>
</body>

</html>