<?php
    include("./conexion.php");

    if($_GET){
        $alum_id = $_GET["id"];

        $sqlConsul = "DELETE FROM todos WHERE id_tod = $alum_id";
        $res = $con -> query($sqlConsul);
    }

    header("location:./index.php");
?>