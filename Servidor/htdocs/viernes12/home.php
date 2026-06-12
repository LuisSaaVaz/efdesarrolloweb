<?php
    include("./conexion.php");

    // Leer la sesión
    session_start();

    if (!isset($_SESSION["viernes12"])) {
        header("location:login.php");
    }

    $idcli = $_SESSION["viernes12"][0];
    $nomcli = $_SESSION["viernes12"][1];
    $emacli = $_SESSION["viernes12"][2];

    $sqlConsul = "SELECT * FROM images WHERE id_cli = '$idcli' AND predeterminada = '1'";
    $res = $con->query($sqlConsul);

    foreach ($res as $img) {
        $idimg = $img["id"];
        $nomimg = $img["name"];
        $preimg = $img["predeterminada"];

    }

    $ruta = "./img/$idcli";
    $ava = "$ruta/$nomimg";

    if ($_FILES) {
        $nomava = $_FILES["avatar"]["name"];
        $nomavatmp = $_FILES["avatar"]["tmp_name"];
        $newavatar = $_POST["newavatar"];

        // Mover el archivo a su destino
        move_uploaded_file($nomavatmp, "$ruta/$nomava");

        $sqlGrab = "INSERT INTO images (name, predeterminada, id_cli) VALUES ('$nomava', '0', '$idcli')";
        // Grabar
        $con->query($sqlGrab);

        header("location:home.php");
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
                <li><a href="./home.php">Home</a></li>
                <li><a href="./logout.php">Logout</a></li>
            </ul>
            <ul><li><a href="./avatar.php"><img src="<?= $ava ?>" alt="avatar"></a></li></ul>
        </nav>
        <hr>
        <h1>Home</h1>
    </header>
    <main>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="avatar" required>
            <label><input type="checkbox" name="newavatar">Definir como avatar</label>

            <button>Añadir</button>
        </form>
    </main>
</body>
</html>