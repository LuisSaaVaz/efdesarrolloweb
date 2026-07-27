<?php
// Configurar MySQLi para que lance excepciones de forma explícita
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Configurar la respuesta siempre en formato JSON para el $.post de jQuery
header('Content-Type: application/json; charset=utf-8');

session_start();

try {
    // Incluir la conexión a la base de datos
    include 'conexion.php';

    // 1. Validar que la petición venga por POST
    if (!$_POST) {
        throw new Exception("Método de petición no permitido.", 405);
    }

    // 2. Obtener y limpiar datos del formulario
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($password)) {
        throw new Exception("Por favor, rellena todos los campos.");
    }

    // 3. Preparar y ejecutar la consulta en la base de datos
    $stmt = $con->prepare("SELECT * FROM clientes WHERE email_cli = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // 4. Comprobar si existe el usuario
    if ($result->num_rows !== 1) {
        throw new Exception("Usuario o contraseña incorrectos.");
    }

    $user = $result->fetch_assoc();

    // 5. Verificar la contraseña:
    // $password es la contraseña en texto plano del formulario
    // $user['pass_cli'] es el hash guardado en la BD
    if (!password_verify($password, $user['pass_cli'])) {
        throw new Exception("Usuario o contraseña incorrectos.");
    }

    // 6. Crear la variable de sesión 'logged'
    $_SESSION['logged'] = [
        'id'         => $user['id_cli'],
        'email'      => $user['email_cli'],
        'nombre'     => $user['nom_cli'] ?? '',
        'login_time' => time()
    ];

    $stmt->close();

    // 7. Respuesta de éxito
    echo json_encode([
        'status'  => 'success',
        'message' => '¡Inicio de sesión correcto! Redirigiendo...'
    ]);
    exit;

} catch (mysqli_sql_exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
    exit;

} catch (Exception $e) {
    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}
?>