<?php
    include("./conexion.php");

    $sqlConsul = "SELECT nom_ima FROM imagenes";
    $res = $con->query($sqlConsul);
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
        <!-- Listar las imagenes -->
        <?php
            if ($res->num_rows > 0) {
        ?>
        <ul>
            <?php
                foreach ($res as $image ) {
                    $nombre = $image["nom_ima"];
            ?>
            <?="<img src='./archivos/$nombre' alt=''>"?>
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
        ?>
    </main>
</body>
</html>