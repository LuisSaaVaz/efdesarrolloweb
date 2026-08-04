<?php
session_start();
require_once "conexion.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre    = trim($_POST['nombre'] ?? '');
    $email     = trim($_POST['email'] ?? '');
    $password  = trim($_POST['password'] ?? '');
    $fecha_nac = trim($_POST['fecha_nacimiento'] ?? '');
    $role      = trim($_POST['role'] ?? 'alumno');

    // Validar campos obligatorios
    if (empty($nombre) || empty($email) || empty($password) || empty($fecha_nac)) {
        echo json_encode(["success" => false, "message" => "Por favor, completa todos los campos requeridos."]);
        exit();
    }

    // Validar formato de fecha (YYYY-MM-DD)
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nac)) {
        echo json_encode(["success" => false, "message" => "El formato de la fecha de nacimiento no es válido."]);
        exit();
    }

    // Protección de Roles: Solo 'admin' puede crear 'profesor' o 'admin'
    if ($role === 'profesor' || $role === 'admin') {
        $usuarioSesion = $_SESSION['usuario'] ?? $_SESSION['logged'] ?? null;
        $rolActual = is_array($usuarioSesion) ? ($usuarioSesion['role'] ?? '') : '';

        if ($rolActual !== 'admin') {
            echo json_encode(["success" => false, "message" => "No tienes permisos para registrar un usuario con rol: " . $role]);
            exit();
        }
    } else {
        // Forzar rol alumno si es un autoregistro público
        $role = 'alumno';
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

    // 2. Hash de contraseña e inserción en BD
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmtInsert = $con->prepare("INSERT INTO usuarios (nombre, email, password, fecha_nacimiento, role) VALUES (?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("sssss", $nombre, $email, $passwordHash, $fecha_nac, $role);

    if ($stmtInsert->execute()) {
        echo json_encode([
            "success" => true,
            "message" => "Usuario registrado con éxito."
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Error al guardar el usuario: " . $con->error]);
    }

    $stmtInsert->close();
    $con->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
