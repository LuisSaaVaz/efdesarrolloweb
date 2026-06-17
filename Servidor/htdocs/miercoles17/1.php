<?php
    $palabra = "luis";

    $palMay = strtoupper($palabra);
    echo "$palabra en mayuscula es $palMay<br>";
    echo "$palabra en mayuscula es ".strtoupper($palabra)."<br>";
    
    $palMin = strtolower($palabra);
    echo "$palMay en minuscula es $palMin<br>";
    echo $palMay." en minuscula es ".$palMin."<br>";

    echo "la primera en mayuscula es " .ucfirst($palabra)."<br>";

    $localidad = "vila garcia de arousa";
    echo ucwords($localidad)."<br>";

    $producto = " rueda ";
    echo "Compré una".$producto."muy barata<br>";
    echo "Compré una".trim($producto)."muy barata<br>";

    
?>