<?php
    $casa1 = array("cocina", "salón", "habitación", "baño", "habitación", "trastero");
    $casa2 = ["cocina", "salón", "habitación", "baño", "habitación", "trastero"];

    echo ucfirst($casa1[3])."<br>";

    foreach ($casa2 as $planta) {
        echo ucfirst($planta)."<br>";
    }

    for ($i=0; $i < count($casa2) ; $i++) { 
        echo ucfirst($casa2[$i])."<br>";
    }
?>