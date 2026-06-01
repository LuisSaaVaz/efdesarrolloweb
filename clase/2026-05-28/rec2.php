<?php
    // POST
    $nom = $_POST["nombre"];
    $ed = $_POST["edad"];
    $ye = $_POST["year"];
    $result = $ed + $ye;
    echo "El nombre de la persona es $nom<br>";
    echo "La suma es $result<br>";
    
    echo "<a href='./form2.html'><button>Volver</button></a>";
?>