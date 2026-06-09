<?php
    include("./menus.php");

    // Leer la sesión
    session_start();

    if (!isset($_SESSION["martes9"])) {
        header("location:entrar.php");
    }

    $nom = $_SESSION["martes9"][1];
    $ema = $_SESSION["martes9"][2];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <?php
            menuLogout();
        ?>
        <hr>
        <h1>Perfil</h1>
    </header>
    <main>
        <?php
            echo "<br>Bienvenido $nom";
            echo "<br>Tu email es $ema";
        ?>
    </main>
</body>
</html>