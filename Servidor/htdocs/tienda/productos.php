<?php
    include("./conexion.php");

    if ($_POST) {
        $prod_nom = $_POST["nombre"];
        $prod_pre = $_POST["precio"];
        $prod_img = $_FILES["imagen"]["name"];
        $prod_tmpimg = $_FILES["imagen"]["tmp_name"];

        $sqlUp = "INSERT INTO productos (nombre, precio, imagen) VALUES ('$prod_nom', '$prod_pre', '$prod_img')";
        $con -> query($sqlUp);

        // Creo el directorio con ese id
        $id = $con->insert_id;
        mkdir("productos/$id", 0777, true);

        // Mover el archivo a su destino
        move_uploaded_file($prod_tmpimg, "./productos/$id/$prod_img");
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
    <main>
        <form method="post" enctype="multipart/form-data">
            <label>
                Nombre
                <input type="text" name="nombre" placeholder="Nombre del producto" required>
            </label>

            <label>
                Precio
                <input type="number" name="precio" placeholder="Ej: 19.99" step="0.01" required>
            </label>

            <label>
                Imagen
                <input type="file" name="imagen" required>
            </label>

            <button type="submit">Insertar Producto</button>
        </form>
    </main>
</body>
</html>