<?php
    include("./conexion.php");

    // Leer la sesión
    session_start();
    $error= null;
    
    if ($_POST) {
        
        // Recibir datos
        $emailcli = $_POST['email_cli'];
        $passcli = $_POST['pass_cli'];

        // SQL para consultar
        $sql = "SELECT * FROM clients WHERE email = '$emailcli'";

        // Ejecutar la Conexión con el SQL guardando el resultado
        $res = $con->query($sql);

        // Comprobar nº resultados
        if ($res->num_rows) {
            // El email esta en la DDBB
            foreach ($res as $cli) {
                $idcli = $cli["id"]; // Plano
                $nomcli = $cli["name"]; // Plano
                $passcliDB = $cli["password"]; // Encriptado

                // Comprobar si el password es correcto
                if (password_verify($passcli, $passcliDB)) {
                    // echo "Te has logeado correctamente";
                    // Crear sesion
                    
                    $_SESSION["viernes12"] = ["$idcli", "$nomcli", "$emailcli"];

                    header("location:home.php");
                } else {
                    $error = "Contraseña erronea";
                }
            }
        } else {
            // El email no esta en la DDBB
            $error = "Email incorrecto";
        }
    }

    if (isset($_SESSION["viernes12"])) {
        header("location:home.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="./register.php">Register</a></li>
                <li><a href="./login.php">Login</a></li>
            </ul>
        </nav>
        <hr>
        <h1>Login</h1>
    </header>
    <main>
        <form method="POST">
            <input type="email" name="email_cli" placeholder="Email">
            <input type="password" name="pass_cli" placeholder="Password">
            
            <button>Entrar</button>
        </form>
        <?php if($error) {
            echo "<p>$error</p>";
        } ?>
    </main>
</body>
</html>