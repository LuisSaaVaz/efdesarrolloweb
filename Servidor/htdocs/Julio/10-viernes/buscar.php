<?php
    $con = new mysqli("10.10.10.160", "clase", "1234", "examenfinal");

    $sqlCon = "SELECT * FROM personal";
    $res = $con->query($sqlCon);

    foreach ($res as $usuario) {
        $nom = $usuario["nombre_per"];
        $ape = $usuario["apellidos_per"];
        echo "$nom $ape<br>";
    }
?>