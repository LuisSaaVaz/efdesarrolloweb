<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    include("conexion.php");

    try {
        // 1. Comprobar que se reciben los datos necesarios por POST
        if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['precio']) && isset($_POST['tipo'])) {
            $id = intval($_POST['id']);
            $nombre = trim($_POST['nombre']);
            $descripcion = trim($_POST['descripcion']);
            $precio = trim($_POST['precio']);
            $tipo = trim($_POST['tipo']);
            
            // 2. Validar que el tipo de tabla sea estrictamente "bebidas" o "postres"
            if ($tipo !== 'bebidas' && $tipo !== 'postres') {
                throw new Exception("Categoría no válida.");
            }

            // 3. Validar que no haya campos vacíos
            if ($nombre === "" || $descripcion === "") {
                throw new Exception("Por favor, rellena todos los campos de texto.");
            }

            // 4. Procesar y validar el precio
            $precioProcesado = str_replace(",", ".", $precio);
            $precioNum = floatval($precioProcesado);

            if ($precioNum <= 0) {
                throw new Exception("El precio debe ser un número válido y mayor que 0.");
            }

            // 5. Preparar y ejecutar la actualización
            $sqlUpd = "UPDATE $tipo SET nombre = ?, descripcion = ?, precio = ? WHERE id = ?";
            
            $stmt = $con->prepare($sqlUpd);
            $stmt->bind_param("ssdi", $nombre, $descripcion, $precioNum, $id);
            
            $stmt->execute();
            
            // Con UPDATE, affected_rows puede ser 0 si el usuario da a guardar sin cambiar nada.
            // Para asegurar que no dé un falso error si no cambió nada, comprobamos si la consulta se ejecutó.
            echo "Elemento actualizado correctamente.";
            
        } else {
            throw new Exception("No se recibieron los datos necesarios para la actualización.");
        }
    } catch (mysqli_sql_exception $e) {
        // Captura errores de base de datos en inglés y responde de forma amigable
        http_response_code(500); 
        echo "Error en la base de datos: No se pudo actualizar el registro.";
    } catch (Exception $e) {
        // Captura excepciones de validación manuales y del sistema
        http_response_code(500); 
        echo $e->getMessage();
    }
?>