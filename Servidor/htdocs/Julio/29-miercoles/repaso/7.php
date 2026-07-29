<?php
include "./conexion.php";

$sqlCon = "SELECT * FROM juguetes";
$res = $con->query($sqlCon);

$lineas = "";

foreach ($res as $juguete) {
    $lineas .= "<tr><td>$juguete[id_jug]</td><td><a href='7.php?id=$juguete[id_jug]'>$juguete[nom_jug]</a></td><td>$juguete[edad_jug]</td></tr>";
}

if ($_GET) {
    $id = $_GET["id"];

    $sqlDel = "DELETE FROM juguetes WHERE id_jug='$id'";

    $con->query($sqlDel);

    header("location: 7.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
</head>

<body>
    <header>
        <h1>Tabla de Juguetes</h1>
    </header>
    <main>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>NOMBRE</th>
                    <th>EDAD</th>
                </tr>
            </thead>
            <tbody>
                <?= $lineas ?>
            </tbody>
        </table>
    </main>
</body>

</html>