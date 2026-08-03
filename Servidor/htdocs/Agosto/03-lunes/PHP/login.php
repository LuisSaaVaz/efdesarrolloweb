<?php
session_start();
require_once "conexion.php";
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        echo json_encode(["success" => false, "message" => "Por favor, completa todos los campos."]);
        exit();
    }

    $stmt = $con->prepare("SELECT id, nombre, email, password, role FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {

            // Guardamos UNICAMENTE la sesión 'logged' como un array con la info del usuario
            $_SESSION['logged'] = [
                "id"     => $user['id'],
                "nombre" => $user['nombre'],
                "email"  => $user['email'],
                "role"   => $user['role']
            ];

            echo json_encode([
                "success" => true,
                "message" => "¡Bienvenido/a, " . $user['nombre'] . "!",
                "usuario" => $_SESSION['logged']
            ]);
        } else {
            echo json_encode(["success" => false, "message" => "Contraseña incorrecta."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "El correo electrónico no está registrado."]);
    }

    $stmt->close();
    $con->close();
} else {
    echo json_encode(["success" => false, "message" => "Método no permitido."]);
}
