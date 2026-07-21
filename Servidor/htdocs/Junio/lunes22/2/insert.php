<?php
    $titulo_pro = $_POST["titulo_pro"];
    $descripcion_pro = $_POST["descripcion_pro"];
    $precio_pro = $_POST["precio_pro"];

    $con = new mysqli("10.10.10.160", "clase", "1234", "tienda");

    $sqlIns = "INSERT INTO productos (titulo_pro, descripcion_pro, precio_pro) VALUES ('$titulo_pro', '$descripcion_pro', '$precio_pro')";

    echo $con->query($sqlIns) ? "Se insertó correctamente" : "Hubo un error en la inserción";

?>