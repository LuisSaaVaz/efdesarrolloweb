<?php
session_start();
require_once "conexion.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre   = trim($_POST['nombre'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role     = trim($_POST['role'] ?? 'alumno');

    if (empty($nombre) || empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Por favor, completa todos los campos requeridos."]);
        exit();
    }

    // Restricción de seguridad: Solo un Admin logueado puede registrar profesores o admins
    if ($role === 'profesor' || $role === 'admin') {
        if (!isset($_SESSION['logged']['role']) || $_SESSION['logged']['role'] !== 'admin') {
            echo json_encode(["success" => false, "message" => "No tienes permisos para registrar a un " . $role]);
            exit();
        }
    }

    // 1. Comprobar si el email ya existe
    $stmtCheck = $con->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();

    if ($resCheck->num_rows > 0) {
        echo json_encode(["success" => false, "message" => "El correo electrónico ya está registrado."]);
        $stmtCheck->close();
        exit();
    }
    $stmtCheck->close();

    // 2. Hash de la contraseña e inserción en la BD
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmtInsert = $con->prepare("INSERT INTO usuarios (nombre, email, password, role) VALUES (?, ?, ?, ?)");
    $stmtInsert->bind_param("ssss", $nombre, $email, $passwordHash, $role);

    if ($stmtInsert->execute()) {

        // 3. Envío de correo electrónico con la función mail() de PHP
        $to      = $email;
        $subject = "Bienvenido/a a ColegioApp";
        $message = "Hola " . $nombre . ",\n\n"
            . "Tu cuenta en ColegioApp ha sido creada correctamente con el rol de '" . ucfirst($role) . "'.\n\n"
            . "Ya puedes iniciar sesión desde la plataforma.\n\n"
            . "Un saludo,\nEl equipo de ColegioApp.";

        $headers = "From: no-reply@colegioapp.com\r\n" .
            "Reply-To: soporte@colegioapp.com\r\n" .
            "X-Mailer: PHP/" . phpversion() . "\r\n" .
            "Content-Type: text/plain; charset=UTF-8\r\n";

        // Intentamos enviar el correo (no bloquea el registro si falla la configuración local)
        @mail($to, $subject, $message, $headers);

        echo json_encode([
            "success" => true,
            "message" => "Usuario registrado con éxito. Se ha enviado un correo de confirmación."
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar el usuario en la base de datos."]);
    }

    $stmtInsert->close();
    $con->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
