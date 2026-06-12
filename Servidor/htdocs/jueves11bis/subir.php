<?php
    include("./conexion.php");

    $sqlConsul = "SELECT DISTINCT(id_cli) FROM imagenes";
    $residclis = $con->query($sqlConsul);

    if ($_POST) {
        // Recoger las partes del archivo
        $idform = $_POST["idcli"];
        $nomimg = $_FILES["lafoto"]["name"];
        $nomimgtemp = $_FILES["lafoto"]["tmp_name"];

        // Crear una UUID
        if ($idform == "Nuevo") {
            $idcli = uniqid();
            $ruta = "./archivos/$idcli";
            mkdir($ruta, 0777, true);
        } else {
            $idcli =$idform;
            $ruta = "./archivos/$idcli";
        }

        // Crear ruta
        

        // Mover el archivo a su destino
        move_uploaded_file($nomimgtemp, "$ruta/$nomimg");

        // Impactar en la DDBB
        $sqlgrab = "INSERT INTO imagenes (id_cli, nom_ima) VALUES ('$idcli', '$nomimg')";
        $con->query($sqlgrab);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="./index.html">Inicio</a></li>
                <li><a href="./subir.php">Grabar imagen</a></li>
                <li><a href="./ver.php">Ver imagenes</a></li>
            </ul>
        </nav>
        <hr>
        <h1>Subida de archivos</h1>
    </header>
    <main>
        <form action="" method="POST" enctype="multipart/form-data" >
            <input type="file" name="lafoto" id="" required>
            <br>
            <label for="">Cliente</label>
            <select name="idcli">
                <option>Nuevo</option>
                <?php
                    foreach ($residclis as $id) {
                        $idoption = $id["id_cli"]
                ?>
                        <?= "<option>$idoption</option>" ?>
                <?php

                    }
                ?>
            </select>

            <br>
            <br>
            <button>Subir</button>
        </form>
        <?php
            if ($_POST && $con->affected_rows > 0) {
                echo "<p>Archivo $nomimg subido correctamente</p>";
            }
        ?>
    </main>
</body>
</html>