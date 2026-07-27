<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');
include 'conexion.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método no permitido.", 405);
    }

    $ema = isset($_POST['email']) ? trim($_POST['email']) : '';
    $newpass = isset($_POST['newpass']) ? $_POST['newpass'] : '';
    $tokenRaw = isset($_POST['token']) ? trim($_POST['token']) : '';

    if (empty($ema) || empty($newpass) || empty($tokenRaw)) {
        throw new Exception("Faltan datos obligatorios para realizar el cambio.");
    }

    // Hashear el token recibido de la URL para compararlo con el de la DDBB
    $tokHash = hash("sha256", $tokenRaw);

    // 1. Verificar si el token y el email coinciden y si NO ha expirado
    $stmt = $con->prepare("SELECT id_cli, expira_cli FROM clientes WHERE email_cli = ? AND token_cli = ?");
    $stmt->bind_param("ss", $ema, $tokHash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("El token o el email son incorrectos.");
    }

    $row = $result->fetch_assoc();
    $fechaActual = date("Y-m-d H:i:s");

    // Validar expiración de 3 minutos
    if ($fechaActual > $row['expira_cli']) {
        throw new Exception("El token ha caducado. Vuelve a solicitar el cambio de contraseña.");
    }

    // 2. Hash de la nueva contraseña
    $passHash = password_hash($newpass, PASSWORD_DEFAULT);

    // 3. Actualizar la contraseña y limpiar el token para que no se pueda reutilizar
    $stmtUpd = $con->prepare("UPDATE clientes SET token_cli = '', pass_cli = ? WHERE id_cli = ?");
    $stmtUpd->bind_param("si", $passHash, $row['id_cli']);
    $stmtUpd->execute();

    if ($stmtUpd->affected_rows > 0) {
        echo json_encode([
            'status' => 'success',
            'mensaje' => '¡Contraseña actualizada con éxito!'
        ]);
    } else {
        throw new Exception("No se pudo actualizar la contraseña.");
    }
    exit;

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'mensaje' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
    exit;

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'mensaje' => $e->getMessage()
    ]);
    exit;
}
?>