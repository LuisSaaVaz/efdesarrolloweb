<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

include("conexion.php");

try {
    // 1. Verificar datos mínimos
    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password'])) {
        
        $nombre   = trim($_POST['nombre']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($nombre) || empty($email) || empty($password)) {
            throw new Exception("Por favor, rellena todos los campos.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo electrónico no es válido.");
        }

        // 2. Control de Roles Automatizado
        // Por defecto es 'user' (Registro público)
        $rolFinal = "user";

        // Si el que registra es un admin logueado, el nuevo usuario será 'admin' por defecto
        if (isset($_SESSION['logged']) && $_SESSION['logged']['role'] === 'admin') {
            $rolFinal = "admin";
        } else {
            // Si NO es admin pero ya está logueado como 'user', bloqueamos que intente registrarse otra vez
            if (isset($_SESSION['logged'])) {
                http_response_code(403);
                throw new Exception("Ya has iniciado sesión con una cuenta activa.");
            }
        }

        // 3. Comprobar duplicados
        // Nota: Asegúrate de mapear bien los nombres de tus columnas (ej: email_usuario o email_per)
        $stmtCheck = $con->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ?");
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $stmtCheck->close();
            throw new Exception("Este correo electrónico ya está registrado.");
        }
        $stmtCheck->close();

        // 4. Encriptar contraseña
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // 5. Insertar en la tabla 'usuarios'
        $stmtInsert = $con->prepare("INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario, rol_usuario) VALUES (?, ?, ?, ?)");
        $stmtInsert->bind_param("ssss", $nombre, $email, $passwordHash, $rolFinal);
        
        if ($stmtInsert->execute()) {
            echo "Usuario registrado correctamente como: " . $rolFinal;
        } else {
            throw new Exception("No se pudo completar el registro.");
        }

        $stmtInsert->close();

    } else {
        throw new Exception("Datos de solicitud incompletos.");
    }

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo "Error interno del servidor de base de datos.";
} catch (Exception $e) {
    if (http_response_code() === 200) {
        http_response_code(400);
    }
    echo $e->getMessage();
}
?>