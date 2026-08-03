<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "colegio";

$con = new mysqli($host, $user, $pass, $db);

if ($con->connect_error) {
    header('Content-Type: application/json');
    echo json_encode([
        "success" => false,
        "message" => "Error de conexión: " . $con->connect_error
    ]);
    exit();
}

// Aseguramos la codificación UTF-8 para tildes y caracteres especiales
$con->set_charset("utf8mb4");
