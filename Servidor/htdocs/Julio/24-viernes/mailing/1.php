<?php
    $para = "luis@efmail.luis";
    $asunto = "Bienvenida";
    $mensaje = "<h1>Hoy es un buen día</h1>";

    $cabeceras = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=HTF-8\r\n";
    $cabeceras .= "From: david@mail.com\r\n";

    mail($para, $asunto, $mensaje, $cabeceras);
?>