<?php
    $con = new mysqli("10.10.10.160", "clase", "1234", "tienda");
    $sqlConsul = "SELECT * FROM productos";

    $res = $con->query($sqlConsul);

    $liList = "";
    foreach ($res as $producto) {
        $id = $producto["id_pro"];
        $titulo = $producto["titulo_pro"];
        $precio = $producto["precio_pro"];

        $liList .= "<li data-pre='$precio'>
            <article>
                <p>$titulo</p>
            </article>
        </li>";

        /* $liList .= "<li onclick='mostrar($precio)'>
                            <article>
                                <p>$titulo</p>
                            </article>
                    </li>"; */
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <h1>Lista de productos</h1>
    </header>
    <main>
        <ul>
            <?= $liList ?>
        </ul>
        <dialog id="modalPrecio">
            <p>Precio del producto:</p>
            <h2 id="valorPrecio"></h2>
            <button id="cerrarModal">CERRAR</button>
        </dialog>
    </main>
    <script>
    $("li").on("click", function() {
        var precio = $(this).attr("data-pre");
        $("#valorPrecio").text(precio + " €"); // Ponemos el dato
        $("#modalPrecio")[0].showModal(); // Abrimos el modal
    });

    /* function mostrar(precio) {
        $("#valorPrecio").text(precio + " €");
        $("#modalPrecio")[0].showModal();
    } */

    $("#cerrarModal").on("click", function() {
        $("#modalPrecio")[0].close(); // Cerramos el modal
    });
    </script>
</body>

</html>