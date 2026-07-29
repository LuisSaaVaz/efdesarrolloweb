<?php
include "./conexion.php";

if ($_POST) {
    $nom = $_POST["nombre"];
    $age = $_POST["edad"];
    $sqlIns = "INSERT INTO juguetes (nom_jug, edad_jug) VALUES ('$nom', '$age')";

    $con->query($sqlIns);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar</title>
</head>

<body>
    <header>
        <h1>Insertar juguetes</h1>
    </header>
    <main>
        <form method="POST">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="number" name="edad" placeholder="Edad minima" required>

            <button>Insertar</button>
        </form>
    </main>
</body>

</html>