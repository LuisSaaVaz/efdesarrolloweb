<?php 
    $con = new mysqli("10.10.10.162", "aula", "1234", "alquiler");

    if ($con->connect_error) {
        die("Fallo en la conexión: " . $con->connect_error);
    }

    // Aseguramos soporte nativo de caracteres e清 (acentos, ñ, etc.)
    $con->set_charset("utf8mb4");
?>