<?php
    // Leer la sesión
    session_start();

    if (isset($_SESSION["clientes"])) {
        $nom = base64_decode($_SESSION["clientes"]);
        echo "Bienvenido de nuevo $nom";
    } else {
        header("location:privado.php");
    }
?>