<?php
    // Recoger datos
    $nom = $_POST["nombre"];
    $ape = $_POST["apellidos"];
    $ema = $_POST["mail"];
    $pss = $_POST["password"];
    $pro = $_POST["provincia"];
    $age = $_POST["nacimiento"];
    $cp = $_POST["cp"];

    // Conexión a la DDBB
    $con = new mysqli("10.10.10.160", "clase", "1234", "martes2");

    // SQL para grabar
    $sql = "INSERT INTO clientes (nombre, apellidos, email, password, provincia, nacimiento, cp) VALUES ('$nom', '$ape', '$ema', '$pss', '$pro', '$age', '$cp')";

    // Ejecutar la Conexión con el SQL
    if ($con->query($sql)) {
        // Mensaje
        echo "Cliente <b>$nom</b> grabado correctamente<br>";
    } else {
        // Mensaje
        echo "No se grabo el cliente<br>";
    }

    // Volver
    echo "<a href='./altas.php'><button>Volver</button></a>";
?>
