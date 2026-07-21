<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    include ("conexion.php");

    try {
        if (isset($_POST['nombre'])) {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $precio = $_POST['precio'];
            $tipo = $_POST['tipo'];
            
            // Validar que el tipo de tabla sea estrictamente "bebidas" o "postres" por seguridad (evita SQL Injection en el nombre de la tabla)
            if ($tipo !== 'bebidas' && $tipo !== 'postres') {
                throw new Exception("Categoría no válida");
            }

            $sqlIns = "INSERT INTO $tipo (nombre, descripcion, precio) VALUES (?, ?, ?)";
            
            $stmt = $con->prepare($sqlIns);
            $stmt->bind_param("ssd", $nombre, $descripcion, $precio);
            
            $stmt->execute();
            $result = $stmt->affected_rows;
    
            if ($result > 0) {
                echo "Se añadió correctamente";
            } else {
                // Lanzamos la excepción para que la capture el catch
                throw new Exception("No se añadió ningún registro.");
            }
        } else {
            throw new Exception("No se recibieron datos.");
        }
    } catch (mysqli_sql_exception $e) {
        // Este bloque captura específicamente CUALQUIER error de base de datos (columnas mal escritas, tablas inexistentes, etc.)
        http_response_code(500); 
        echo "Error en la base de datos: No se pudo realizar la operación.";
    } catch (Exception $e) {
        // Configuramos la cabecera HTTP para que jQuery sepa que ha ocurrido un error
        http_response_code(500); 
        
        // Enviamos el mensaje de error que se ha producido
        echo $e->getMessage();
    }
?>