<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
        // POST
        $nom = $_POST['nombre'];
        $vue = $_POST['vuela'];
        // Conexión a la DDBB
        $con = new mysqli("10.10.10.160", "clase", "1234", "martes2");

        // Comprobar si ya existe el nombre
        $sqlConsul = "SELECT * FROM animales WHERE nombre = '$nom'";

        // Consultar
        $response = $con->query($sqlConsul);
        $rows = $response->num_rows;
        if ($rows > 0) {
            ?>
            <p>El nombre <?=$nom?> ya existe</p>
            <?php
        } else {
            // SQL para grabar
            $sqlGrab = "INSERT INTO animales (nombre, vuela, alumno) VALUES ('$nom', '$vue', 'Luis')";
            // Grabar
            $con->query($sqlGrab);
        }

    ?>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>VUELA</th>
            <th>ALUMNO</th>
        </tr>
        <?php
            // SQL para consultar
            $sqlConsul = "SELECT * FROM animales  ORDER BY id DESC";

            // Consultar
            $response = $con->query($sqlConsul);
            $rows = $response->num_rows;

            if ($rows > 0) {
            foreach ($response as $animal ) {
                $id = $animal["id"];
                $nom = $animal["nombre"];
                $vue = ($animal["vuela"]) ? "Si" : "No" ;
                $alu = $animal["alumno"];

        ?>

        <tr>
            <th><?=$id?></th>
            <td><?=$nom?></td>
            <td><?=$vue?></td>
            <td><?=$alu?></td>
        </tr>
        <?php
            }
        
            } else {
        ?>
        <tr>
            <th>--</th>
            <td>--</td>
            <td>--</td>
            <td>--</td>
        </tr>
        <?php
            }
        ?>
    </table>
    <br>
    <a href='./8.html'><button>Volver</button></a>
</body>
</html>