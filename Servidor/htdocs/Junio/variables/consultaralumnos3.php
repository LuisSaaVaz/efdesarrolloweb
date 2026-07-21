<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        th {
            background-color : yellow;
        }
    </style>
</head>
<body>
    <h1>Alumnos</h1>
    <table border=1>
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>EMAIL</th>
            <th>EDAD</th>
            <th>PROVINCIA</th>
        </tr>
        <?php
            // Conexión a la DDBB
            $con = new mysqli("localhost", "root", "", "primera");

            // SQL para grabar
            $sql = "SELECT * FROM alumnos";

            // Ejecutar la Conexión con el SQL guardando el resultado
            $response = $con->query($sql);

            // Recorrer la respuesta
            foreach ($response as $alumno ) {
                $id = $alumno["id"];
                $nom = $alumno["nombre"];
                $ema = $alumno["email"];
                $age = $alumno["edad"];
                $pro = $alumno["provincia"];
        ?>

        <tr>
            <th><?=$id?></th>
            <td><?=$nom?></td>
            <td><?=$ema?></td>
            <td><?=$age?></td>
            <td><?=$pro?></td>
        </tr>
        <?php
            }
        ?>
    </table>
</body>
</html>