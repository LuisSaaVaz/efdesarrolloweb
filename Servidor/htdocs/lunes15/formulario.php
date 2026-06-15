<?php
    include("./conexion.php");
    
    if($_GET){
        $alum_id = $_GET["id"];

        $sqlConsul = "SELECT * FROM todos WHERE id_tod = $alum_id";
        $res = $con -> query($sqlConsul);

        /* foreach ($res as $alu) {
            $alum_nom = $alu["nom_tod"];
            $alum_ape = $alu["ape_tod"];
            $alum_edad = $alu["edad_tod"];
        } */

        // Fetch
        // $alu = $res -> fetch_array();
        $alu = $res -> fetch_assoc();
        $alum_nom = $alu["nom_tod"];
        $alum_ape = $alu["ape_tod"];
        $alum_edad = $alu["edad_tod"];

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="./style.css">
</head>
<body>
    <header>
        <h1>Actualizando a <?= "$alum_nom $alum_ape" ?></h1>
    </header>
    <form action="./actualizar.php" method="post">
        <label>
            Nombre
            <input type="text" name="nom" placeholder="Nombre" value="<?= $alum_nom ?>" required>
        </label>
        <br>
        <label>
            Apellidos
            <input type="text" name="ape" placeholder="Apellidos" value="<?= $alum_ape ?>" required>
        </label>
        <br>
        <label>
            Edad
            <input type="number" name="edad" placeholder="Edad" value="<?= $alum_edad ?>" required>
        </label>
        <input type="hidden" name="id" value="<?= $alum_id ?>" required>
        <br>
        <br>

        <button>Actualizar</button>
    </form>
</body>
</html>