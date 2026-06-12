<?php
    include("./conexion.php");

    if ($_POST) {
        $idselect = $_POST["idcli"];
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
        <h1>Ver archivos</h1>
    </header>
    <main>
        <form method="POST">
            <select name="idcli">
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

            <button>Elegir cliente</button>
        </form>
        <!-- Listar las imagenes -->
        <?php
        if ($_POST) {
            
            $sqlConsul = "SELECT id_cli, nom_ima FROM imagenes WHERE id_cli='$idselect'";
            $res = $con->query($sqlConsul);
        ?>
        <h2>Lista de fotos de <?= $idselect ?></h2>
        <ul>
            <?php
            if ($res->num_rows > 0) {
                foreach ($res as $image ) {
                    $nombre = $image["nom_ima"];
                    $idcli = $image["id_cli"];
            ?>
            <?="<li><img src='./archivos/$idcli/$nombre' alt=''></li>"?>
            <?php
            }
            ?>
        </ul>
            <?php
            } else {
            ?>
            <?="<p>No hay imagenes</p>"?>
        <?php
                        }
            } else{
        ?>
            <?="<p>No seleccionaste una opción</p>"?>
        <?php
            }
        ?>
    </main>
</body>
</html>