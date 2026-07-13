<?php 
    include("conexion.php");

    $sqlCon = "SELECT titulo_pro, precio_pro FROM productos";

    $res = $con->query($sqlCon);

    /* foreach ($res as $product) {
        $tit = $product["titulo_pro"];
        $pre = $product["precio_pro"];

        echo "<p>" . $product["titulo_pro"] . " " . $product["precio_pro"] . "<p>";
    } */

    $productos = $res ->fetch_all(MYSQLI_ASSOC);
    // fetch_assoc() da solo una fila de key y valor
    // fetch_array() da 1 sola fila acceso por indice y por atributo
    // fetch_all() da todos los resultados por indice
        // MYSQLI_ASSOC da los datos de esa fila por key
        // MYSQLI_NUM da los datos de esa fila por indice

    echo json_encode($productos);
?>