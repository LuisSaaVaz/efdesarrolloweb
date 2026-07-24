<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include("conexion.php");

    try {
        if($_POST){
            $nom = $_POST["nombre"];
            $ema = $_POST["email"];
            $password = $_POST["password"];
            $passHash = password_hash($password, PASSWORD_DEFAULT);

            // Generar una cadena aleatoria y hashearla
            $token = bin2hex(random_bytes(32));
            $tokHash = hash("sha256", $token);

            // Fecha caducidad token
            $expira = date("Y-m-d H:i:s", strtotime("+3 minutes"));

            $sqlIns = "INSERT INTO clientes (nom_cli, email_cli, pass_cli, token_cli, expira_cli ) VALUES (?, ?, ?, ?, ?)";
            
            $stmt = $con->prepare($sqlIns);
            $stmt->bind_param("sssss", $nom, $ema, $passHash, $tokHash, $expira);
            
            $stmt->execute();
            $result = $stmt->affected_rows;
    
            if ($result > 0) {
                echo "Se añadió correctamente";
            } else {
                // Lanzamos la excepción para que la capture el catch
                throw new Exception("No se añadió ningún registro.");
            }
    
            $para = $ema;
            $asunto = "Activar cuenta";
            $mensaje = "<h1>Bienvenido $nom</h1>\r\n
            <p>Para activar tu cuenta haz click en el <a href='http://localhost/Julio/24-viernes/mailing/activarCuenta.php?t=$token'>enlace</a></p>\r\n";
    
            

            $cabeceras = "MIME-Version: 1.0\r\n";
            $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
            $cabeceras .= "From: admin@mail.com\r\n";
    
            mail($para, $asunto, $mensaje, $cabeceras);
        }
    } catch (mysqli_sql_exception $e) {
        // Este bloque captura específicamente CUALQUIER error de base de datos (columnas mal escritas, tablas inexistentes, etc.)
        http_response_code(500); 
        $message = $e->getMessage();
        echo "Error en la base de datos: $message.";
    } catch (Exception $e) {
        // Configuramos la cabecera HTTP para que jQuery sepa que ha ocurrido un error
        http_response_code(500); 
        $message = $e->getMessage();
        // Enviamos el mensaje de error que se ha producido
        echo $message;
    }
?>