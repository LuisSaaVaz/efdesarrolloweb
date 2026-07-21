<?php
    include("./conexion.php");

    
    if ($_POST) {
        $id_ces = $_POST["idces"];
        $sqlDel = "DELETE FROM cesta WHERE id='$id_ces' ";
        $con ->query($sqlDel);
    }
    $sqlConsul = "SELECT CE.id, CE.cantidad, PRO.id as idpro, PRO.nombre, PRO.precio, PRO.imagen FROM cesta CE JOIN productos PRO ON CE.id_pro = PRO.id";
    $res = $con ->query($sqlConsul);

    $tot = 0;
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
            <h1>Cesta</h1>
            <ul>
                <li>
                    <a href="./index.php">
                        <i class="fa-solid fa-shop" style="color: rgb(99, 230, 190);"></i>
                    </a>
                </li>
            </ul>
        </nav>
    </header>
    <main>
    <?php
        if($res->num_rows > 0){
    ?>
        <ul class="cesta">
    <?php
            foreach ($res as $producto) {
            $id_ces = $producto["id"];
            $can_ces = $producto["cantidad"];
            $id_pro = $producto["idpro"];
            $nom_pro = $producto["nombre"];
            $pre_pro = $producto["precio"];
            $im_pro = $producto["imagen"];
            $tot_pro = $can_ces * $pre_pro;

            $tot += $tot_pro;
    ?>
        <?= 
            "<li>
                <article>
                    <img src='./productos/$id_pro/$im_pro'>
                    <p>$nom_pro</p>
                    <p>$tot_pro</p>
                </article>
                <form method='post'>
                    <input type='hidden' name='idces' value='$id_ces'>
                    <button><i class='fa-solid fa-circle-minus' style='color: rgb(255, 0, 0);'></i></button>
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
        <?= "<p>Cesta vacia</p>" ?>
    <?php
        }
    ?>
    <p>Total: <?= $tot ?></p>
    </main>
</body>
</html>