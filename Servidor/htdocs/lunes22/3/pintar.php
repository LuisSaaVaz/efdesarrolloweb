<?php
    $con = new mysqli("10.10.10.160", "clase", "1234", "tienda");
    $sqlConsul = "SELECT * FROM butacas";

    $res = $con->query($sqlConsul);

    $liList = "";
    foreach ($res as $butaca) {
        $id = $butaca["id_but"];
        $num = $butaca["num_but"];
        $ocupada = $butaca["disponible_but"];
        $color = $ocupada ? "red" : "lime";
        $claseBloqueo = $ocupada ? "bloqueada" : "";

        $liList .= "<li><i class='fa-solid fa-couch $claseBloqueo' style='color: $color' id='$num' >$num</i></li>";
    }

    echo $liList;
?>