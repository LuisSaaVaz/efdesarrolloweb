<?php
    include("./menus.php");
    session_start();

    if (isset($_POST['cerrar_sesion'])) {
        session_destroy();
    }

    if (!isset($_SESSION["martes9"])) {
        header("location:entrar.php");
        exit();
    }
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
        <h1>Salir</h1>
    </header>
    <main>
        <h2>Gracias por tu visita</h2>
        <br>
        <form method="POST">
            <button type="submit" name="cerrar_sesion">Salir</button>
        </form>
    </main>
</body>
</html>