<?php
    // Conectar a MYSQL
    $con = new mysqli("localhost", "root", "", "");

    // 
    $sqlDDBB = "CREATE DATABASE IF NOT EXISTS miercoles10";

    // Crear DDBB
    $con->query($sqlDDBB);
    
    // Conectar a la DDBB
    $con = new mysqli("localhost", "root", "", "miercoles10");
    
    $sqltable = "CREATE TABLE IF NOT EXISTS ficheros(
        id INT   PRIMARY KEY AUTO_INCREMENT,
        nom_fich VARCHAR(50)
    )";

    // Crear Table
    $con->query($sqltable);

    if ($_POST || $_FILES) {
        // Recibir datos
        $nomfich = $_FILES["archivo"]["name"];
        
        $nomfichtemp = $_FILES["archivo"]["tmp_name"];

        move_uploaded_file($nomfichtemp, "./ficheros/$nomfich");

        // SQL para grabar
        $sqlGrab = "INSERT INTO ficheros (nom_fich) VALUES ('$nomfich')";

        // Grabar
        $con->query($sqlGrab);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="POST" enctype="multipart/form-data">
        <input type="file" name="archivo" id="">
        <br>
        <br>
       
        <button>Enviar</button>
    </form>
</body>
</body>
</html>