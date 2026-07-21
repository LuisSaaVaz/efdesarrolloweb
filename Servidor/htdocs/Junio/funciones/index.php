<?php
    include("./menus.php");

    // Leer la sesión
    session_start();
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
            if (isset($_SESSION["martes9"])) {
                menuLogout();
                
            } else {
                menuLogin();
            }
        ?>
        <hr>
        <h1>Inicio</h1>
    </header>
</body>
</html>