<?php
    include("./menus.php");

    // Conectar a la DDBB
    $con = new mysqli("10.10.10.160", "clase", "1234", "martes9");

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
        <h1>Contacto</h1>
    </header>
    <main>
        <form>
            <input type="email" name="email_per" placeholder="Email">
            <br>
            <input type="text" name="text_per" placeholder="Mensaje">
            <br>
            <br>
            <button>Enviar</button>
        </form>
    </main>
</body>
</html>