<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['logged'])) {
    echo json_encode([
        "logged"  => true,
        "usuario" => $_SESSION['logged'] // Ya contiene id, nombre, email y role
    ]);
} else {
    echo json_encode([
        "logged" => false
    ]);
}
