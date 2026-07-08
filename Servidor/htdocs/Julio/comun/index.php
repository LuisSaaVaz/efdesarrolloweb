<?php
    session_start();
    include("./createDDBB.php");
    
    crear();
    
    // Procesar login
    function login($con) {
        // Iniciamos sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) { session_start(); }
        
        $email = $_POST['email'];
        $password_input = $_POST['password'];

        // Consulta segura
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? AND role = 'teacher'");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if ($resultado->num_rows == 1) {
            $user = $resultado->fetch_assoc();
            
            // Verificamos el hash de la contraseña
            if (password_verify($password_input, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['nombre'] = $user['nombre'];
                $_SESSION['apellidos'] = $user['apellidos'];
                $_SESSION['dni'] = $user['dni'];
                
                header("location:fichar.php");
                exit();
            }
        }
        
        // Si llega aquí, algo falló (email no existe o pass incorrecta)
        return "Credenciales incorrectas.";
    }
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
        
    </head>
    <body>
        <header>

        </header>
        <main class="container d-flex justify-content-center align-items-center vh-100">
            <div class="card p-4 shadow d-flex flex-column gap-4" style="width: 350px;">
                <h2 class="text-center text-primary m-0">Login</h2>
                <form class="d-flex flex-column gap-2" onsubmit="login()" method="POST">
                    <div class="form-floating">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" required>
                        <label for="floatingInput">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" class="form-control" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button type="submit" name="btn_login" class="btn btn-primary w-100">Entrar</button>
                </form>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    </body>
</html>
