<!-- Visualizar los ultimos 5 registros -->

<?php
include "./conexion.php";

$sqlCon = "SELECT * FROM juguetes";
$res = $con->query($sqlCon);

$lineas = "";

foreach ($res as $juguete) {
    $lineas .= "<tr><td>$juguete[id_jug]</td><td><a href='5.php?id=$juguete[id_jug]'>$juguete[nom_jug]</a></td><td>$juguete[edad_jug]</td></tr>";
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