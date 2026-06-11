<?php
    include("./conexion.php");
    if ($_FILES) {
        // Recoger las partes del archivo
        $nomimg = $_FILES["lafoto"]["name"];
        $nomimgtemp = $_FILES["lafoto"]["tmp_name"];

        // Mover el archivo a su destino
        move_uploaded_file($nomimgtemp, "./archivos/$nomimg");

        // Impactar en la DDBB
        $sqlgrab = "INSERT INTO imagenes (nom_ima, id_cli) VALUES ('$nomimg', '1')";
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