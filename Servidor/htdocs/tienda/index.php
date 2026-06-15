<?php
    include("./conexion.php");

    $sqlConsul = "SELECT * FROM productos";
    $res = $con ->query($sqlConsul);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <i></i>
    </header>

    <ul>
        <?php
        if ($res->num_rows > 0) {
            foreach ($res as $producto) {
                $id_pro = $producto["id"];
                $nom_pro = $producto["nombre"];
                $pre_pro = $producto["precio"];
                $im_pro = $producto["image"];
            ?>
            <?= "<li>
                    <img src='./productos/$im_pro' alt=''>
                    <div></div>
                    <p>$nom_pro</p>
                    <p>$pre_pro</p>
                </li>" ?>
                <?php
            } else {
            # code...
            }
        }

            
        ?>
    </ul>
</body>
</html>