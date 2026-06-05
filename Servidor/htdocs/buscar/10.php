<?php 
    // Conectar a la DDBB
    $con = new mysqli("10.10.10.160", "clase", "1234", "martes2");

    // POST
    if ($_POST) {
        // Recibir datos
        $nomcla = $_POST['nombre_cla'];
        $apecla = $_POST['apellido_cla'];

        // SQL para grabar
        $sqlGrab = "INSERT INTO clases (nombre_cla, apellido_cla) VALUES ('$nomcla', '$apecla')";
        // Grabar
        $con->query($sqlGrab);

        // Sacar la id de la ultima inserción sin consulta
        $ult_id = $con -> insert_id;

        // Sacar la id de la ultima inserción con consulta
        $sqlConsul= "SELECT MAX(id_cla) as maximo FROM clases";
        $response = $con->query($sqlConsul);
        foreach ($response as $clase) {
            $max_id = $clase["maximo"];
        }

        // Sacar el id recien insertado sin volver a buscar de otra forma

        // $dato = $response->fetch_assoc();
        // $max_id = $dato["maximo"];

        // SQL para grabar
        $sqlGrab = "INSERT INTO personas (id_cla, nom_per) VALUES ('$max_id', 'Luis')";
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
    <h1>Animales</h1>
    <form method="POST">
        <input type="text" name="nombre_cla" placeholder="Nombre" required>
        <br>
        <input type="text" name="apellido_cla" placeholder="Apellido" required>
        
        <br>
        <br>
        <button>Enviar</button>
    </form>

    <br>
    <br>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>NOMBRE CLA</th>
                <th>APELLIDO CLA</th>
                <th>NOMBRE PER</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // SQL para consultar
                $sqlConsul = "
                    SELECT CLA.id_cla, nombre_cla, apellido_cla, nom_per 
                        FROM clases CLA
                        LEFT JOIN personas PER
                        ON CLA.id_cla = PER.id_cla
                        ORDER BY CLA.id_cla
                    ";

                // Consultar
                $response = $con->query($sqlConsul);
                $rows = $response->num_rows;

                if ($rows > 0) {
                foreach ($response as $clase ) {
                    $idcla = $clase["id_cla"];
                    $nomcla = $clase["nombre_cla"];
                    $apecla = $clase["apellido_cla"];
                    $nomper = $clase["nom_per"];
                    
            ?>
            <tr>
                <th><?=$idcla?></th>
                <td><?=$nomcla?></td>
                <td><?=$apecla?></td>
                <td><?=$nomper?></td>
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
        </tbody>
        <?php
            }
        ?>
    </table>
</body>
</html>