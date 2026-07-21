<?php
    include("./conexion.php");

    $sqlConsul = "SELECT * FROM todos ORDER BY nom_tod ASC";
    $res = $con ->query($sqlConsul);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Tabla de todos</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>APELLIDOS</th>
                <th>EDAD</th>
                <th colspan="2">ACCIONES</th>
            </tr>
        </thead>
        <tbody>
            <?php

                foreach ($res as $alum) {
                    $alum_id = $alum["id_tod"];
                    $alum_nom = $alum["nom_tod"];
                    $alum_ape = $alum["ape_tod"];
                    $alum_edad = $alum["edad_tod"];
            ?>
            <?= 
                "<tr>
                    <td>$alum_id</td>
                    <td>$alum_nom</td>
                    <td>$alum_ape</td>
                    <td>$alum_edad</td>
                    <td><a href='./formulario.php?id=$alum_id' ><button>Editar</button></a></td>
                    <td><a href='./borrar.php?id=$alum_id' ><button>Borrar</button></a></td>
                </tr>" 
            ?>
            <?php
                }
            ?>
        </tbody>
    </table>
</body>
</html>