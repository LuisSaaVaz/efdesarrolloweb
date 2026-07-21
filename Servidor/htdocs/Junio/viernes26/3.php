<?php
    $con = new mysqli("10.10.10.160", "clase", "1234", "tienda");
    $sqlConsul = "SELECT * FROM productos";

    $res = $con->query($sqlConsul);

    $liList = "";
    foreach ($res as $producto) {
        $id = $producto["id_pro"];
        $titulo = $producto["titulo_pro"];
        $nombre = $producto["nom_pro"];
        $descripcion = $producto["descripcion_pro"];
        $precio = $producto["precio_pro"];

        $liList .= "<tr><td>$id</td><td>$titulo</td><td>$nombre</td><td>$descripcion</td><td>$precio</td></tr>";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <header>
        <h1>Busqueda</h1>
    </header>
    <main>
        <input type="text" placeholder="Busqueda exacta" onkeyup="buscar()">
        <br><br>
        <table border="1">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TÍTULO</th>
                    <th>NOMBRE</th>
                    <th>DESCRIPCIÓN</th>
                    <th>PRECIO</th>
                </tr>
            </thead>
            <tbody>
                <?= $liList ?>
            </tbody>
        </table>
    </main>
    <script>
    function buscar() {
        var texto = $("input").val();
        $("tr").css("background-color", "white")

        $("td").each(function() {
            if ($(this).text() != "" && $(this).text() === texto) {
                $(this).parent().css("background-color", "yellow")
            }
        })
    }
    </script>
</body>

</html>