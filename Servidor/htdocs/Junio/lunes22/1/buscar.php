<?php
    $bus = $_POST["busqueda"];
    $con = new mysqli("10.10.10.160", "clase", "1234", "tienda");
    $sqlConsul = "SELECT * FROM productos WHERE titulo_pro LIKE '%$bus%'";
    $res = $con->query($sqlConsul);
    $list = "";
    foreach ($res as $item) {
        $elemento = $item["titulo_pro"];
        $list .= "<li>$elemento</li>";
    }
    echo "$list";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

</body>

</html>