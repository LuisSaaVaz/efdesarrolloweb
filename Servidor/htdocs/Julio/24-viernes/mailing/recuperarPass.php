<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');
include 'conexion.php';

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Método no permitido.", 405);
    }

    $ema = isset($_POST['email']) ? trim($_POST['email']) : '';

    if (empty($ema)) {
        throw new Exception("El email es obligatorio.");
    }

    // 1. Verificar si existe el usuario
    $stmt = $con->prepare("SELECT nom_cli FROM clientes WHERE email_cli = ?");
    $stmt->bind_param("s", $ema);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("No existe ninguna cuenta asociada a este email.");
    }

    $usuario = $result->fetch_assoc();
    $nom = $usuario['nom_cli'];

    // 2. Generar token y expiración
    $token = bin2hex(random_bytes(32));
    $tokHash = hash("sha256", $token);
    $expira = date("Y-m-d H:i:s", strtotime("+3 minutes"));

    // 3. Actualizar la tabla clientes con el nuevo token y expiración
    $stmtUpd = $con->prepare("UPDATE clientes SET token_cli = ?, expira_cli = ? WHERE email_cli = ?");
    $stmtUpd->bind_param("sss", $tokHash, $expira, $ema);
    $stmtUpd->execute();

    // 4. Enviar email con el enlace a changePass.html incluyendo el token en la URL
    $para = $ema;
    $asunto = "Restablecer contraseña";
    $mensaje = "<h1>Hola $nom</h1>\r\n
    <p>Has solicitado restablecer tu contraseña. Haz clic en el siguiente enlace para continuar:</p>\r\n
    <p><a href='http://localhost/Julio/24-viernes/mailing/changePass.html?t=$token'>Restablecer contraseña</a></p>\r\n
    <p>Este enlace caducará en 3 minutos.</p>";

    $cabeceras = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
    $cabeceras .= "From: admin@mail.com\r\n";

    if (!mail($para, $asunto, $mensaje, $cabeceras)) {
        throw new Exception("Error al enviar el correo electrónico.");
    }

    echo json_encode([
        'status' => 'success',
        'mensaje' => 'Revise su correo electrónico.'
    ]);
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