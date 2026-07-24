<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    include("conexion.php");

    $message = "";
    try{
        if($_GET){
            $token = $_GET["t"];

            $tokHash = hash("sha256", $token);

            $sqlCon = "SELECT * FROM clientes WHERE token_cli=$tokHash AND expira_cli > now()";
            $stmt = $con->prepare("SELECT * FROM clientes WHERE token_cli = ? AND expira_cli > now()");
            $stmt->bind_param("s", $tokHash);
            $stmt->execute();
            $res = $stmt->get_result();

            if($res -> num_rows == 1){
                $response = $res ->fetch_assoc();
                $id = $response["id_cli"]; 
                $sqlUpd = "UPDATE clientes SET token_cli='', activo_cli = '1' WHERE id_cli=$id";
                $con ->query($sqlUpd);
                $message = "Usuario Activado";
            } else {
                $message = "No se pudo activar el usuario";
            }
            
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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <header>
        <h1>Activación de usuario</h1>
    </header>
    <main>
        <p><?= $message ?></p>
    </main>
</body>

</html>