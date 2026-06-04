<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>NOMBRE</th>
            <th>APELLIDOS</th>
            <th>EMAIL</th>
            <th>PASSWORD</th>
            <th>PROVINCIA</th>
            <th>NACIMIENTO</th>
            <th>CP</th>
        </tr>
        <?php
            // GET
            $ape = $_GET['apellidos'];

            // Conexión a la DDBB
            $con = new mysqli("10.10.10.160", "clase", "1234", "martes2");

            // SQL para consultar
            $sql = "SELECT * FROM clientes WHERE email LIKE '%$ape%' ORDER BY id DESC LIMIT 1";
            $sql = "SELECT * FROM clientes  ORDER BY rand() LIMIT 5";

            // Ejecutar la Conexión con el SQL guardando el resultado
            $response = $con->query($sql);
            $rows = $response->num_rows;

            if ($rows > 0) {
            foreach ($response as $client ) {
                $id = $client["id"];
                $nom = $client["nombre"];
                $ape = $client["apellidos"];
                $ema = $client["email"];
                $pss = $client["password"];
                $prov = $client["provincia"];
                $nac = $client["nacimiento"];
                $cp = $client["cp"];

        ?>

        <tr>
            <th><?=$id?></th>
            <td><?=$nom?></td>
            <td><?=$ape?></td>
            <td><?=$ema?></td>
            <td><?=$pss?></td>
            <td><?=$prov?></td>
            <td><?=$nac?></td>
            <td><?=$cp?></td>
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
            <td>--</td>
            <td>--</td>
            <td>--</td>
            <td>--</td>
        </tr>
        <?php
            }
        ?>
    </table>
    <br>
    <a href='./5.html'><button>Volver</button></a>
</body>
</html>