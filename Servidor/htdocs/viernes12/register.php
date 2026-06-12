<?php
    include("./conexion.php");

    // Leer la sesión
    session_start();

    if ($_POST) {
        // Recibir datos
        $nomcli = $_POST['nom_cli'];
        $emailcli = $_POST['ema_cli'];
        $passcli = $_POST['pass_cli'];
        $encripasscli = password_hash($passcli, PASSWORD_DEFAULT);
        $nomava = $_FILES['avatar']['name']; 
        $nomavatmp = $_FILES['avatar']['tmp_name']; 

        // SQL para grabar
        $sqlGrab = "INSERT INTO clients (name, email, password) VALUES ('$nomcli', '$emailcli', '$encripasscli')";
        // Grabar
        $con->query($sqlGrab);

        // Creo el directorio con ese id
        $id = $con->insert_id;
        mkdir("img/$id", 0777, true);

        // Mover el archivo a su destino
        move_uploaded_file($nomavatmp, "./img/$id/$nomava");

        $sqlGrab = "INSERT INTO images (name, predeterminada, id_cli) VALUES ('$nomava', '1', '$con->insert_id')";
        // Grabar
        $con->query($sqlGrab);



        header("location:login.php");
    }

    if (isset($_SESSION["viernes12"])) {
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
                <li><a href="./register.php">Register</a></li>
                <li><a href="./login.php">Login</a></li>
            </ul>
        </nav>
        <hr>
        <h1>Register</h1>
    </header>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="nom_cli" placeholder="Nombre" required>
        <input type="email" name="ema_cli" placeholder="Email" required>
        <input type="password" name="pass_cli" placeholder="Password" required>
        <input type="file" name="avatar" id="" required>
        
        <button>Register</button>
    </form>
</body>
</html>