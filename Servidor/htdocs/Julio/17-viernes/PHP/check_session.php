<?php
    // PHP/check_session.php
    header('Content-Type: application/json; charset=utf-8');
    session_start();

    // Si la sesión existe, devolvemos los datos estructurados
    if (isset($_SESSION['logged'])) {
        echo json_encode([
            'logged' => true,
            'nombre' => $_SESSION['logged']['nombre'],
            'role'   => $_SESSION['logged']['role']
        ]);
    } else {
        // Si no está logueado, responde false limpiamente sin errores HTTP
        echo json_encode([
            'logged' => false
        ]);
    }
    exit;
?>