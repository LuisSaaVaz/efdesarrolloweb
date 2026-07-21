<?php
    // Recoger datos
    $nom = "Pepe";
    $age = 38;
    $mail = "pepe@email.com";

    // Conexión a la DDBB
    $con = new mysqli("localhost", "root", "", "primera");

    // SQL para grabar
    $sql = "INSERT INTO alumnos (nombre, edad, email) VALUES ('$nom', '$age', '$mail')";

    // Ejecutar la Conexión con el SQL
    $con->query($sql);
?>