<?php
    include("./menus.php");

    // Conectar a la DDBB
    $con = new mysqli("10.10.10.160", "clase", "1234", "martes9");

    // Leer la sesión
    session_start();

    if (!isset($_SESSION["martes9"])) {
        header("location:entrar.php");
    }

    $idper = $_SESSION["martes9"][0];
    $nom = $_SESSION["martes9"][1];
    $ema = $_SESSION["martes9"][2];

    if ($_FILES) {
        // Recibir datos
        $nomfich = $_FILES["avatar"]["name"];
        
        $nomfichtemp = $_FILES["avatar"]["tmp_name"];

        move_uploaded_file($nomfichtemp, "./avatars/$idper/$nomfich");

        // SQL para grabar
        $sqlGrab = "INSERT INTO avatares (nom_ava, id_per) VALUES ('$nomfich', $idper)";

        // Grabar
        $con->query($sqlGrab);
    }

    if ($_POST) {
        // Recibir datos
        $nomper = $_POST['nombre'];
        $emaper = $_POST['email'];
        
        // SQL para grabar
        $sqlGrab = "UPDATE personal SET nom_per='$nomper' , email_per='$emaper' WHERE id_per=$idper";
        
        // Grabar
        $con->query($sqlGrab);
        $_SESSION["martes9"][1] = $nomper;
        $_SESSION["martes9"][2] = $emaper;

        header("location:perfil.php");
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
        <h1>Perfil</h1>
    </header>
    <main>
        <?php
            echo "<h2>Bienvenido $nom</h2>";
            echo "<p>Tu email es $ema</p>";
        ?>

        <h2>Actualizar usuario</h2>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre" value="<?= $nom ?>" >
            <br>
            <input type="email" name="email" placeholder="Email" value="<?= $ema ?>" >
            <br>
            <br>
            <button>Enviar</button>
        </form>

        <h2>Avatar</h2>
        <form method="POST" enctype="multipart/form-data">
            <input type="file" name="avatar">
            <br>
            <br>
            <button>Enviar</button>
        </form>
    </main>
</body>
</html>