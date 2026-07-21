<?php
    $ids = json_decode($_POST['ids']);

    $con = new mysqli("10.10.10.160", "clase", "1234", "tienda");

    foreach ($ids as $id) {
        // Actualizamos disponible_but a 1
        $sqlUp = "UPDATE butacas SET disponible_but = 1 WHERE num_but = '$id'";
        $con->query($sqlUp);
        
        $sqlIns = "INSERT INTO reservas (num_but, nombre_per) VALUES ('$id', 'Luis')";
        $con->query($sqlIns);

    }

    echo "Se reservaron las butacas";
?>