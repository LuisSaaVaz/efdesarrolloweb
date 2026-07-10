<?php
    include("conexion.php");

    // Recogemos los parámetros con valores por defecto por seguridad
    $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : 'lista';
    $limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 0;

    // Construimos la consulta dinámica
    $sqlCon = "SELECT * FROM productos";
    if ($limite > 0) {
        $sqlCon .= " ORDER BY precio_pro DESC LIMIT " . $limite;
    }

    $res = $con->query($sqlCon);

    // Variable para controlar el primer elemento del carrusel (debe llevar la clase 'active')
    $esPrimero = true;

    foreach ($res as $producto) {
        $id = $producto["id_pro"];
        $tit = $producto["titulo_pro"];
        $des = $producto["descripcion_pro"];
        $pre = $producto["precio_pro"];

        if ($tipo === 'carousel') {
            // Renderizado para el Carrusel de Bootstrap
            $claseActive = $esPrimero ? 'active' : '';
            echo "<div class='carousel-item " . $claseActive . "'>"
                ."<img src='https://picsum.photos/1200/400?random=" . $id . "' class='d-block w-100' alt='" . $tit . "' style='object-fit: cover; max-height: 400px;'>"
                ."<div class='carousel-caption d-none d-md-block' style='background: rgba(0,0,0,0.5); border-radius: 10px;'>"
                    ."<h5>" . $tit . "</h5>"
                    ."<p>" . $des . " - <strong>" . $pre . "€</strong></p>"
                ."</div>"
            ."</div>";
            $esPrimero = false; // Solo el primero será active
        } else {
            // Renderizado por defecto (Tus Cards actuales)
            echo "<li class='card' style='width: 18rem;'>"
                ."<img src='https://picsum.photos/200/150?random=" . $id ."'>"
                ."<div class='card-body'>"
                    ."<h5 class='card-title'>" . $tit . "</h5>"
                    ."<p class='card-text'>" . $des . ".</p>"
                    ."<p class='card-text'><strong>Precio:</strong> " . $pre . "€</p>"
                    ."<a href='#' class='btn btn-primary btn-success col-12' ><i class='fa-solid fa-cart-plus' style='color: white;'></i></a>"
                ."</div>"
            ."</li>";
        }
    }
?>