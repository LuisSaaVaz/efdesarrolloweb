<?php
    include ("conexion.php");

    if (isset($_GET['tipo'])) {
        $tipo = $_GET['tipo'];

        // Validamos que el tipo sea seguro para evitar inyecciones en el nombre de la tabla
        if ($tipo === 'usuarios' || $tipo === 'vehiculos'  || $tipo === 'reservas') {
            
            // Consulta SQL limpia
            $sql = "SELECT * FROM $tipo";
            $resultado = $con->query($sql);

            $datos = [];
            if ($resultado) {
                while ($fila = $resultado->fetch_assoc()) {
                    $datos[] = $fila;
                }
            }

            // Devolvemos el array codificado en JSON
            echo json_encode($datos);
            exit();
        }
    }

    // Si hay algún fallo o el tipo no es válido, devolvemos un array vacío
    echo json_encode([]);
?>