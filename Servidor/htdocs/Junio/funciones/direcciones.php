<?php
    include("./menus.php");

    
    // Leer la sesión
    session_start();
    $idper = $_SESSION["martes9"][0];
    
    if ($_POST) {
        // Conectar a la DDBB
        $con = new mysqli("10.10.10.160", "clase", "1234", "martes9");
        
        // Recibir datos
        $dirdir = $_POST['dir_dir'];

        // SQL para grabar
        $sqlGrab = "INSERT INTO direcciones (id_per, dir_dir) VALUES ('$idper', '$dirdir')";
        // Grabar
        $con->query($sqlGrab);
    }

    if (!isset($_SESSION["martes9"])) {
        header("location:entrar.php");
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
    <header>
        <?php
            menuLogout();
        ?>
        <hr>
        <h1>Direcciones</h1>
    </header>
    <main>
        <form method="POST">
            <input type="text" name="dir_dir" placeholder="Direccion">
            <br>
            <button>Enviar</button>
        </form>

        <br>
        <br>

        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DIRECCIÓN</th>
                    <th>USUARIO</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // SQL para consultar
                    $sqlConsul = "
                        SELECT id_dir, dir_dir, nom_per 
                            FROM direcciones DIR
                            LEFT JOIN personal PER
                            ON DIR.id_per = PER.id_per
                        ";

                    // Consultar
                    $response = $con->query($sqlConsul);
                    $rows = $response->num_rows;

                    if ($rows > 0) {
                    foreach ($response as $direc ) {
                        $iddir = $direc["id_dir"];
                        $nomdir = $direc["dir_dir"];
                        $nomper = $direc["nom_per"];
                        
                ?>
                <tr>
                    <th><?=$iddir?></th>
                    <td><?=$nomdir?></td>
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
                </tr>
            </tbody>
            <?php
                }
            ?>
        </table>
    </main>
</body>
</html>