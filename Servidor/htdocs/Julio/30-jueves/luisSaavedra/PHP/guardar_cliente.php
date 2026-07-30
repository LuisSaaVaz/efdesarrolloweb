<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json');

include "./conexion.php";

$nombre   = $_POST['nombre'] ?? '';
$email    = $_POST['email'] ?? '';
$telefono = $_POST['telefono'] ?? '';

if (empty($nombre) || empty($email) || empty($telefono)) {
    echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios.']);
    exit();
}

try {
    // 1. Iniciar transacción
    $con->begin_transaction();

    // 2. Bloquear la fila en la tabla 'ids' para la entidad 'clientes'
    $stmt = $con->prepare("SELECT lastId FROM ids WHERE tabla = 'clientes' FOR UPDATE");
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        $nuevoId = $row['lastId'] + 1;

        // Actualizar el contador
        $updateStmt = $con->prepare("UPDATE ids SET lastId = ? WHERE tabla = 'clientes'");
        $updateStmt->bind_param("i", $nuevoId);
        $updateStmt->execute();
        $updateStmt->close();
    } else {
        // Registro inicial si aún no existe el contador en la tabla 'ids'
        $nuevoId = 1;
        $insertStmt = $con->prepare("INSERT INTO ids (tabla, lastId) VALUES ('clientes', 1)");
        $insertStmt->execute();
        $insertStmt->close();
    }
    $stmt->close();

    // 3. Insertar el nuevo cliente con el ID obtenido
    $insertCliente = $con->prepare("INSERT INTO clientes (id_cli, nombre, email, telefono) VALUES (?, ?, ?, ?)");
    $insertCliente->bind_param("isss", $nuevoId, $nombre, $email, $telefono);
    $insertCliente->execute();
    $insertCliente->close();

    // 4. Confirmar la transacción
    $con->commit();

    // 5. Envío de email de bienvenida
    $para = $email;
    $asunto = "Bienvenido a nuestra plataforma";
    $mensaje = "<h1>¡Bienvenido/a, $nombre!</h1>\r\n"
        . "<p>Gracias por darte de alta. Tu registro se ha completado correctamente con el ID: <strong>$nuevoId</strong>.</p>\r\n";

    $cabeceras  = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
    $cabeceras .= "From: admin@mail.com\r\n";

    // Enviamos el correo (opcionalmente puedes verificar si devuelve true/false)
    @mail($para, $asunto, $mensaje, $cabeceras);

    echo json_encode([
        'success' => true,
        'message' => "Cliente guardado e email enviado con éxito. ID asignado: $nuevoId"
    ]);
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    // Revertir cambios si hay error
    $con->rollback();
    echo json_encode([
        'success' => false,
        'message' => 'Error al guardar en la BD: ' . $e->getMessage()
    ]);
}