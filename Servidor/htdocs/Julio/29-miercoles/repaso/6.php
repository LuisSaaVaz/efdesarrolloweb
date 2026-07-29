<?php
include "./conexion.php";
if ($_POST) {
    $id = $_POST["id"];
    $nom = $_POST["nombre"];
    $age = $_POST["edad"];
}

$sqlUp = "UPDATE juguetes SET nom_jug='$nom', edad_jug='$age' WHERE id_jug='$id'";
$res = $con->query($sqlUp);

$message = "";

if ($con->affected_rows == 1) {
    $message .= "Se actualizo correctamente.";
} else {
    $message .= "No se pudo actualizar.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualización</title>
</head>

<body>
    <header>
        <h1>Actualización</h1>
    </header>
    <main>
        <p><?= $message ?></p>
    </main>
</body>

</html>