<?php 
    // Conectar a la DDBB
    $con = new mysqli("10.10.10.160", "clase", "1234", "martes2");

    // POST
    if ($_POST) {
        // Recibir datos
        $nomalu = $_POST['nombre_alu'];
        $pro = $_POST['provincia'];

        // SQL para grabar
        $sqlGrab = "INSERT INTO alumnos (nombre_alu, id_pro) VALUES ('$nomalu', '$pro')";
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
        <input type="text" name="nombre_alu" placeholder="Nombre" required>
        <br>
        <label>
            Provincia
            <select name="provincia">
                <?php 
                    // SQL para consultar
                    $sqlConsul = "SELECT * FROM provincias ORDER BY nombre_pro ASC";

                    // Consultar
                    $response = $con->query($sqlConsul);
                    $rows = $response->num_rows;

                    if ($rows > 0) {
                    foreach ($response as $prov ) {
                        $idpro = $prov["id_pro"];
                        $nompro = $prov["nombre_pro"];
                ?>
                <option value="<?=$idpro?>"><?=$nompro?></option>
                <?php
                        }
                    }
                ?>
            </select>
        </label>
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
                <th>NOMBRE CLI</th>
                <th>NOMBRE PRO</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // SQL para consultar
                $sqlConsul = "
                    SELECT id_alu, nombre_alu, nombre_pro FROM alumnos ALU
                        JOIN provincias PRO
                        ON ALU.id_pro = PRO.id_pro
                        ORDER BY id_alu DESC
                    ";

                // Consultar
                $response = $con->query($sqlConsul);
                $rows = $response->num_rows;

                if ($rows > 0) {
                foreach ($response as $alumno ) {
                    $idalu = $alumno["id_alu"];
                    $nomalu = $alumno["nombre_alu"];
                    $nompro = $alumno["nombre_pro"];

            ?>
            <tr>
                <th><?=$idalu?></th>
                <td><?=$nomalu?></td>
                <td><?=$nompro?></td>
            </tr>
            <?php
                }
            
                } else {
            ?>
            <tr>
                <th>--</th>
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