<?php
    include("./menus.php");

    // Leer la sesión
    session_start();
    // session_destroy();
    
    if ($_POST) {
        // Conectar a la DDBB
        $con = new mysqli("10.10.10.160", "clase", "1234", "martes9");
        
        // Recibir datos
        $emailper = $_POST['email_per'];
        $passper = $_POST['pass_per'];

        // SQL para consultar
        $sql = "SELECT * FROM personal WHERE email_per = '$emailper'";

        // Ejecutar la Conexión con el SQL guardando el resultado
        $res = $con->query($sql);

        // Comprobar nº resultados
        if ($res->num_rows) {
            // El email esta en la DDBB
            foreach ($res as $per) {
                $idper = $per["id_per"]; // Plano
                $nomper = $per["nom_per"]; // Plano
                $passperDB = $per["pass_per"]; // Encriptado

                // Comprobar si el password es correcto
                if (password_verify($passper, $passperDB)) {
                    // echo "Te has logeado correctamente";
                    // Crear sesion
                    
                    $_SESSION["martes9"] = ["$idper", "$nomper", "$emailper"];
                } else {
                    echo "Contraseña erronea";
                }
            }
        } else {
            // El email no esta en la DDBB
            echo "Email incorrecto";
        }
    }

    if (isset($_SESSION["martes9"])) {
        header("location:index.php");
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <header>
        <?php
            menuLogin();
        ?>
        <hr>
        <h1>Entrar</h1>
    </header>
    <main>
        <form method="POST">
            <input type="email" name="email_per" placeholder="Email">
            <br>
            <input type="password" name="pass_per" placeholder="Password">
            <br>
            <br>
            <button>Entrar</button>
        </form>
    </main>
</body>
</html>