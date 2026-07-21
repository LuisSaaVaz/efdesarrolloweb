<?php
    include("./conexion.php");

    $sqlConsul = "SELECT * FROM productos";
    $res = $con ->query($sqlConsul);

    if ($_POST) {
        $id = $_POST["id_pro"];
        $cant = $_POST["cant_pro"];

        $sqlConsul = "INSERT INTO cesta (id_pro, cantidad) VALUES('$id', '$cant')";
        $con ->query($sqlConsul);
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <nav>
            <h1>Productos</h1>
            <ul>
                <li>
                    <a href="./cesta.php">
                        <i class="fa-solid fa-cart-shopping" style="color: rgb(99, 230, 190);"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <main>
    <?php
        if($res->num_rows > 0){
    ?>
        <ul class="productos">
    <?php
            $producto = $res ->fetch_assoc();
            foreach ($res as $producto) {
                $id_pro = $producto["id"];
                $nom_pro = $producto["nombre"];
                $pre_pro = $producto["precio"];
                $im_pro = $producto["imagen"];
    ?>
        <?= 
            "<li>
                <img src='./productos/$id_pro/$im_pro' alt=''>
                <p>$nom_pro</p>
                <p>$pre_pro</p>
                <form method='POST'>
                    <input type='hidden' name='id_pro' value='$id_pro'>
                    <input type='number' name='cant_pro' min='1' value='1'>
                    <button><i class='fa-solid fa-cart-plus' style='color: rgb(99, 230, 190);'></i></button>
                </form>
            </li>"
        ?>
    <?php
            }
    ?>
        </ul>
    <?php
        } else {
    ?>
        <?= "<p>No hay productos</p>" ?>
    <?php
        }
    ?>
    </main>
</body>
</html>