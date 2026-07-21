<?php
    include("./conexion.php");

    if ($_POST) {
        $alum_id = $_POST["id"];
        $alum_nom = $_POST["nom"];
        $alum_ape = $_POST["ape"];
        $alum_edad = $_POST["edad"];

        $sqlUp = "UPDATE todos SET nom_tod='$alum_nom', ape_tod='$alum_ape', edad_tod='$alum_edad' WHERE id_tod = '$alum_id'";
        $con -> query($sqlUp);
    }

    header("location:./index.php");
?>