<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

// Comprobar si existe la variable de sesión 'logged'
if (isset($_SESSION['logged'])) {
    echo json_encode([
        'logged' => true,
        'usuario' => $_SESSION['logged']
    ]);
} else {
    echo json_encode([
        'logged' => false
    ]);
}
exit;
?>