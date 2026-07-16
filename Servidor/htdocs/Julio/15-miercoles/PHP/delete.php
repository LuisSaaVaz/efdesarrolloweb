<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    include("conexion.php");

    try {
        // 1. Comprobar que se reciben los datos necesarios por POST
        if (isset($_POST['id']) && isset($_POST['tipo'])) {
            $id = intval($_POST['id']);
            $tipo = trim($_POST['tipo']);
            
            // 2. Validar que el tipo de tabla sea estrictamente "bebidas" o "postres"
            if ($tipo !== 'bebidas' && $tipo !== 'postres') {
                throw new Exception("Categoría no válida.");
            }

            // 3. Preparar y ejecutar la eliminación
            $sqlDel = "DELETE FROM $tipo WHERE id = ?";
            
            $stmt = $con->prepare($sqlDel);
            $stmt->bind_param("i", $id);
            
            $stmt->execute();
            $result = $stmt->affected_rows;
    
            if ($result > 0) {
                echo "Elemento eliminado correctamente.";
            } else {
                // Si affected_rows es 0, significa que ese ID ya no existía en la base de datos
                throw new Exception("El registro no existe o ya ha sido eliminado.");
            }
        } else {
            throw new Exception("No se recibieron los parámetros necesarios para borrar.");
        }
    } catch (mysqli_sql_exception $e) {
        // Captura errores de base de datos en inglés y responde de forma amigable
        http_response_code(500); 
        echo "Error en la base de datos: No se pudo eliminar el registro.";
    } catch (Exception $e) {
        // Captura excepciones de validación manuales y del sistema
        http_response_code(500); 
        echo $e->getMessage();
    }
?>