<?php
    // Recoger datos
    $pro = $_POST["provincia"];
    $nom = $_POST["nombre"];
    $ema = $_POST["mail"];
    $age = $_POST["edad"];

    // Conexión a la DDBB
    $con = new mysqli("localhost", "root", "", "primera");

    // SQL para grabar
    $sql = "INSERT INTO alumnos (provincia, nombre, email, edad) VALUES ('$pro', '$nom', '$ema', '$age')";

    // Ejecutar la Conexión con el SQL
    $con->query($sql);

    if ($con) {
        // Mensaje
        echo "Alumno <b>$nom</b> grabado correctamente<br>";
    } else {
        // Mensaje
        echo "No se grabo el alumno<br>";
    }
    


    // Volver
    echo "<a href='./formalumnos.html'><button>Volver</button></a>";
?>