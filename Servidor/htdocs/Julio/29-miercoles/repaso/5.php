<?php
include "./conexion.php";
if ($_GET) {
    $id = $_GET["id"];

    $sqlCon = "SELECT * FROM juguetes WHERE id_jug=$id";

    $res = $con->query($sqlCon);

    $isExist = $res->num_rows == 1;
    $pintar = "";

    if ($isExist) {
        $juguete = $res->fetch_assoc();
        $pintar = "
            <form action='6.php' method='POST'>
                <input type='hidden' name='id' placeholder='Id' value='$juguete[id_jug]'><br>
                <input type='text' name='nombre' placeholder='Nombre' value='$juguete[nom_jug]'><br>
                <input type='number' name='edad' placeholder='Edad' value='$juguete[edad_jug]'><br>
                <br>
                <button>Update</button>
            </form>
        ";
    } else {
        $pintar = "<p>No existe</p>";
    }
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
        <h1>Actualizar Juguete</h1>
    </header>
    <main>
        <?= $pintar ?>
    </main>
</body>

</html>