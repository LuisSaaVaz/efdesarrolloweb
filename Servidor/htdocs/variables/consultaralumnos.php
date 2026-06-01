<?php
    // Conexión a la DDBB
    $con = new mysqli("localhost", "root", "", "primera");

    // SQL para grabar
    $sql = "SELECT * FROM alumnos";

    // Ejecutar la Conexión con el SQL guardando el resultado
    $response = $con->query($sql);

    // Recorrer la respuesta
    foreach ($response as $alumno ) {
        # code...
        $nom = $alumno["nombre"];
        $ema = $alumno["email"];
        $age = $alumno["edad"];
        $pro = $alumno["provincia"];

        echo "$nom, $ema, $age, $pro<br>";
    }
?>