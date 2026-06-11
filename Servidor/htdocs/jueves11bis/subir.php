<?php
    include("./conexion.php");
    if ($_FILES) {
        // Recoger las partes del archivo
        $nomimg = $_FILES["lafoto"]["name"];
        $nomimgtemp = $_FILES["lafoto"]["tmp_name"];
        $idform = $_POST["idcli"];

        // Crear una UUID
        if($idform == "Nuevo"){
            $idcli = uniqid();
        } else {
            $idcli = $idform;
        }

        // Crear ruta
        $ruta = "./archivos/$idcli";
        mkdir($ruta, 0777, true);

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
            <input type="file" name="lafoto" id="">
            <br>
            <label for="">Cliente</label>
            <select name="idcli">
                <option>Nuevo</option>
                <?php
                    $sqlConsul = "SELECT DISTINCT(id_cli) FROM imagenes";
                    $residclis = $con->query($sqlConsul);
                    
                    foreach ($residclis as $idcli) {
                        $idoption = $idcli["id_cli"]
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
            if ($con->affected_rows > 0) {
                echo "<p>Archivo $nomimg subido Correctamente</p>";
            }
        ?>
    </main>
</body>
</html>