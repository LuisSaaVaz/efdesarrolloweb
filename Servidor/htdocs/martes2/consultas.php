<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table {
            border: red;
        }
        th {
            background-color : yellow;
        }
    </style>
</head>
<body>
    <header>
        <menu>
            <ul>
                <a href="./index.html"><button>Home</button></a>
                <a href="./altas.php"><button>Altas</button></a>
                <a href="./consultas.php"><button>Consultas</button></a>
            </ul>
        </menu>
        <hr>
        <h1>Alumnos</h1>
    </header>
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
            // Conexión a la DDBB
            $con = new mysqli("10.10.10.160", "clase", "1234", "martes2");

            // SQL para grabar
            $sql = "SELECT * FROM clientes";

            // Ejecutar la Conexión con el SQL guardando el resultado
            $response = $con->query($sql);

            // Recorrer la respuesta
            foreach ($response as $client ) {
                $id = $client["id"];
                $nom = $client["nombre"];
                $ape = $client["apellidos"];
                $ema = $client["email"];
                $pss = $client["password"];
                $pro = $client["provincia"];
                $nac = $client["nacimiento"];
                $cp = $client["cp"];
                ?>

        <tr>
            <th><?=$id?></th>
            <td><?=$nom?></td>
            <td><?=$ape?></td>
            <td><?=$ema?></td>
            <td><?=$pss?></td>
            <td><?=$pro?></td>
            <td><?=$nac?></td>
            <td><?=$cp?></td>
        </tr>
        <?php
            }
        ?>
    </table>
</body>
</html>