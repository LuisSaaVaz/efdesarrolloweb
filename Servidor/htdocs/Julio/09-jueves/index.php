<?php 
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Add users</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
        <style>
            .dropdown-menu .dropdown-item:hover {
                background-color: var(--bs-primary);
                color: white;
            }
        </style>
    </head>
    <body>
        <header>
            <?php include 'nav.php'; ?>
        </header>
        <main class="container d-flex justify-content-center align-items-center vh-100">
            <?php if(!isset($_SESSION['logged'])): ?>
                <div class="card p-4 shadow d-flex flex-column gap-4" style="width: 350px;">
                    <div id="form-register" class="d-none">
                        <h2 class="text-center text-primary m-0">Register</h2>
                        <form class="d-flex flex-column gap-2" method="POST">
                            <div class="form-floating">
                                <input type="text" name="nombre" class="form-control" id="floatingInput" placeholder="Nombre" required>
                                <label for="floatingInput">Nombre</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" name="apellidos" class="form-control" id="floatingInput" placeholder="Apellidos" required>
                                <label for="floatingInput">Apellidos</label>
                            </div>
                            <div class="form-floating">
                                <input type="text" name="dni" class="form-control" id="floatingInput" placeholder="DNI" required>
                                <label for="floatingInput">DNI</label>
                            </div>
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <button type="submit" name="btn_add_user" class="btn btn-primary w-100">Add</button>
                        </form>
                    </div>
                    <div id="form-login">
                        <h2 class="text-center text-primary m-0">Login</h2>
                        <form class="d-flex flex-column gap-2" action="login.php" method="POST">
                            <div class="form-floating">
                                <input type="email" name="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                                <label for="floatingInput">Email address</label>
                            </div>
                            <div class="form-floating">
                                <input type="password" name="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                                <label for="floatingPassword">Password</label>
                            </div>
                            <button type="submit" name="btn_login" class="btn btn-primary w-100">Login</button>
                        </form>
                        <p class="text-center mt-2">¿No tienes cuenta? <a href="" id="go-register">Registro</a></p>
                    </div>
                </div>
            <?php endif; ?>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
                        

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

        <script src="./toggleLogReg.js"></script>
    </body>
</html>