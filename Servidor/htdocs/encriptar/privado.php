<?php
    // Leer la sesión
    session_start();

    if (isset($_SESSION["clientes"])) {
        $nom = base64_decode($_SESSION["clientes"]);
        echo "Bienvenido $nom";
    } else {
        header("location:login.html");
    }

    echo "<br><a href='./privado2.php'><button>Privado 2</button></a>";
?>