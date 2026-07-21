<?php
    // POST
    $nom = $_POST["nombre"];
    $des = $_POST["descripcion"];
    $price = $_POST["precio"];
    
    // Conexión a la DDBB
    $con = new mysqli("localhost", "root", "", "primera");

    // SQL para grabar
    $sql = "INSERT INTO productos (nombre, descripcion, precio) VALUES ('$nom', '$des', '$price')";

    // Ejecutar la Conexión con el SQL
    $con->query($sql);

    // Mensaje
    echo "Producto <b>$nom</b> grabado correctamente<br>";

    // Volver
    echo "<a href='./formproducts.html'><button>Volver</button></a>";
?>