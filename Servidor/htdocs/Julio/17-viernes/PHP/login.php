<?php
// PHP/login.php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();
include("conexion.php");

try {
    if (!isset($_POST['email']) || !isset($_POST['password'])) {
        throw new Exception("Error en la solicitud de datos.");
    }

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        throw new Exception("Por favor, rellena todos los campos.");
    }

    // Consulta adaptada a las columnas de tu base de datos
    // NOTA: Ajusta 'usuarios' por 'personal' (y sus columnas) si usas la otra tabla
    $stmt = $con->prepare("SELECT id_usuario, nombre_usuario, email_usuario, rol_usuario, password_usuario FROM usuarios WHERE email_usuario = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificamos el hash seguro de la contraseña
        if (password_verify($password, $user['password_usuario'])) {
            $_SESSION['logged'] = [
                'id'     => $user['id_usuario'],
                'nombre' => $user['nombre_usuario'],
                'email'  => $user['email_usuario'],
                'role'   => $user['rol_usuario']
            ];
            echo "¡Inicio de sesión correcto!";
        } else {
            throw new Exception("Usuario o contraseña incorrectos.");
        }
    } else {
        throw new Exception("Usuario o contraseña incorrectos.");
    }
    
    $stmt->close();

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo "Error interno del servidor de base de datos.";
} catch (Exception $e) {
    http_response_code(401); // Código de estado 'No autorizado'
    echo $e->getMessage();
}
exit;
?>