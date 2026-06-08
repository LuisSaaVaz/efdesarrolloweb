<?php
    // Conectar a la DDBB
    $con = new mysqli("localhost", "root", "", "lunes8");

    if ($_POST) {
        // Recibir datos
        $nomcli = $_POST['nombre'];
        $encrinomcli = base64_encode($nomcli);
        $emailcli = $_POST['email'];
        $encriemailcli = base64_encode($emailcli);
        $passcli = $_POST['password'];
        $encripasscli = password_hash($passcli, PASSWORD_DEFAULT);

        // SQL para grabar
        $sqlGrab = "INSERT INTO clientes (nom_cli, email_cli, password_cli) VALUES ('$encrinomcli', '$encriemailcli', '$encripasscli')";
        // Grabar
        $con->query($sqlGrab);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Productos

    </title>
</head>
<body>
    <center><h1>Alta Clientes</h1></center>
    <form  method="POST">
        <input type="text" name="nombre" maxlength="100" placeholder="Nombre" required>
        <br>
        <input type="email" name="email" placeholder="Email" required>
        <br>
        <input type="password" name="password" placeholder="Password" required>
        <br>
        <br>
        <button>Enviar</button>
    </form>
</body>
</html>