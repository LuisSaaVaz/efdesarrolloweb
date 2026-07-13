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
            // Renderizado de las tarjetas igualadas en altura
            echo "<li class='d-flex justify-content-center m-0 p-0' style='width: 18rem;'>"
                ."<div class='card w-100 d-flex flex-column' style='height: 450px;'>" 
                    
                    // CONTENEDOR DE LA IMAGEN: Le añadimos position-relative
                    ."<div class='position-relative' style='height: 150px;'>"
                        ."<img src='https://picsum.photos/200/150?random=" . $id ."' class='card-img-top h-100' alt='" . $tit . "' style='object-fit: cover;'>"
                        
                        // Icono Izquierdo: Corazón vacío (fa-solid fa-heart)
                        ."<a href='#' class='position-absolute top-0 start-0 m-2 text-white' style='text-shadow: 0 0 4px rgba(0,0,0,0.8); font-size: 1.25rem;'>"
                            ."<i class='fa-solid fa-heart text-primary'></i>"
                        ."</a>"
                        
                        // Icono Derecho: Papelera (fa-solid fa-trash)
                        ."<a href='#' class='position-absolute top-0 end-0 m-2 text-white' style='text-shadow: 0 0 4px rgba(0,0,0,0.8); font-size: 1.25rem;'>"
                            ."<i class='fa-solid fa-trash text-danger'></i>"
                        ."</a>"
                    ."</div>"
                    
                    ."<div class='card-body d-flex flex-column justify-content-between' style='height: calc(100% - 150px);'>"
                        
                        // Bloque superior: Título + Descripción con scroll
                        ."<div class='d-flex flex-column' style='flex-grow: 1; overflow: hidden;'>"
                            ."<h5 class='card-title' style='min-height: 48px; margin-bottom: 8px; overflow: hidden;'>" . $tit . "</h5>"
                            ."<div class='card-text text-muted' style='flex-grow: 1; overflow-y: auto; font-size: 0.9rem; padding-right: 4px;'>"
                                .$des . "."
                            ."</div>"
                        ."</div>"
                        
                        // Bloque inferior: Precio estático y Botón abajo del todo
                        ."<div class='mt-3'>"
                            ."<p class='mb-2'><strong>Precio:</strong> " . $pre . "€</p>"
                            ."<a href='#' class='btn btn-success col-12'><i class='fa-solid fa-cart-plus' style='color: white;'></i></a>"
                        ."</div>"

                    ."</div>"
                ."</div>"
            ."</li>";
        }
    }
?>