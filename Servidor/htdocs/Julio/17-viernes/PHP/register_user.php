<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
session_start();

include("conexion.php");

try {
    // 1. RESTRICCIÓN DE SESIÓN EX EXISTENTE para usuarios comunes
    // Si ya hay una sesión iniciada y NO es un administrador, bloqueamos el acceso al registro
    if (isset($_SESSION['logged'])) {
        if ($_SESSION['logged']['role'] !== 'admin') {
            http_response_code(403); // Prohibido
            throw new Exception("Ya has iniciado sesión. No puedes registrar una cuenta nueva ahora.");
        }
    }

    // 2. VERIFICACIÓN DE DATOS RECIBIDOS
    if (isset($_POST['nombre']) && isset($_POST['email']) && isset($_POST['password'])) {
        
        $nombre   = trim($_POST['nombre']);
        $email    = trim($_POST['email']);
        $password = trim($_POST['password']);

        if (empty($nombre) || empty($email) || empty($password)) {
            throw new Exception("Por favor, rellena todos los campos obligatorios.");
        }

        // Validador básico de email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception("El formato del correo electrónico no es válido.");
        }

        // 3. CONTROL ESTRICTO DE ROLES
        // Por defecto, cualquier registro externo será de tipo 'user'
        $rolFinal = "user";

        // Solo si hay un administrador logueado, permitimos que asigne un rol personalizado (ej. 'admin')
        if (isset($_SESSION['logged']) && $_SESSION['logged']['role'] === 'admin') {
            $rolFinal = "admin";
        }

        // 4. COMPROBAR SI EL EMAIL YA EXISTE EN LA BASE DE DATOS
        $stmtCheck = $con->prepare("SELECT id_usuario FROM usuarios WHERE email_usuario = ?");
        $stmtCheck->bind_param("s", $email);
        $stmtCheck->execute();
        $resultCheck = $stmtCheck->get_result();

        if ($resultCheck->num_rows > 0) {
            $stmtCheck->close();
            throw new Exception("Este correo electrónico ya está registrado.");
        }
        $stmtCheck->close();

        // 5. ENCRIPTAR LA CONTRASEÑA (Seguridad Obligatoria)
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // 6. INSERCIÓN EN LA BASE DE DATOS
        // Ajusta los nombres de las columnas a los de tu tabla 'usuarios'
        $stmtInsert = $con->prepare("INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario, rol_usuario) VALUES (?, ?, ?, ?)");
        $stmtInsert->bind_param("ssss", $nombre, $email, $passwordHash, $rolFinal);
        
        if ($stmtInsert->execute()) {
            echo "Usuario registrado correctamente con rol: " . $rolFinal;
        } else {
            throw new Exception("No se pudo completar el registro.");
        }

        $stmtInsert->close();

    } else {
        throw new Exception("Solicitud no válida de datos.");
    }

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo "Error interno en el servidor de base de datos.";
} catch (Exception $e) {
    // Si no se ha configurado un código previo (como el 403), enviamos un 400 (Bad Request)
    if (http_response_code() === 200) {
        http_response_code(400);
    }
    echo $e->getMessage();
}
?>