<?php
    include("./conexion.php");

    $sqlConsul = "SELECT * FROM productos";
    $res = $con->query($sqlConsul);
    $index = 1;

    $list="";
    foreach ($res as $product ) {
        $list .= "<li class='card m-3' style='width: 18rem;'>"
            ."<img src='https://picsum.photos/200/150?random=" . $index ."'>"
            ."<div class='card-body'>"
                ."<h5 class='card-title'>" . $product['titulo_pro'] . "</h5>"
                ."<p class='card-text'>" . $product['descripcion_pro'] . ".</p>"
                ."<a href='#' class='btn btn-primary btn-success col-12' ><i class='fa-solid fa-cart-plus' style='color: white;'></i></a>"
            ."</div>"
        ."</li>";

        $index++;
    }
?>