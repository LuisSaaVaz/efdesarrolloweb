<?php
    include("./menus.php");

    // Conectar a la DDBB
    $con = new mysqli("10.10.10.160", "clase", "1234", "martes9");

    // Leer la sesión
    session_start();

    if ($_POST) {
        // Recibir datos
        $nomper = $_POST['nom_per'];
        $emailper = $_POST['email_per'];
        $passper = $_POST['pass_per'];
        $encripassper = password_hash($passper, PASSWORD_DEFAULT);

        // SQL para grabar
        $sqlGrab = "INSERT INTO personal (nom_per, email_per, pass_per) VALUES ('$nomper', '$emailper', '$encripassper')";
        // Grabar
        $con->query($sqlGrab);

        mkdir("avatares/$con->insert_id", 0777, true);

        header("location:entrar.php");
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
    <title>Register</title>
</head>
<body>
    <header>
        <?php
            menuLogin();
        ?>
        <hr>
        <h1>Registro</h1>
    </header>
    <main>
        <form method="POST">
            <input type="text" name="nom_per" placeholder="Nombre">
            <br>
            <input type="email" name="email_per" placeholder="Email">
            <br>
            <input type="password" name="pass_per" placeholder="Password">
            <br>
            <br>
            <button>Registrarse</button>
        </form>
    </main>
</body>
</html>