<?php
session_start();
header('Content-Type: application/json');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // 1. Validar Sesión
    if (!isset($_SESSION['logged']) || empty($_SESSION['logged'])) {
        throw new Exception('Sesión no iniciada. Por favor, vuelve a ingresar.');
    }

    $usuario = $_SESSION['logged'];

    if ($usuario['role'] !== 'admin') {
        throw new Exception('Acceso no autorizado: requiere rol de admin.');
    }

    require_once '../conexion.php';

    // 2. Capturar Filtros
    $busqueda       = isset($_GET['busqueda']) && trim($_GET['busqueda']) !== '' ? trim($_GET['busqueda']) : null;
    $rol            = isset($_GET['rol']) && trim($_GET['rol']) !== '' ? trim($_GET['rol']) : null;
    $anioNacimiento = isset($_GET['anio_nacimiento']) && is_numeric($_GET['anio_nacimiento']) ? intval($_GET['anio_nacimiento']) : null;

    // --------------------------------------------------------------------------
    // CONSULTAR USUARIOS CON FILTROS DINÁMICOS
    // --------------------------------------------------------------------------
    $sqlUsuarios = "SELECT id, nombre, email, fecha_nacimiento, role, created_at 
                    FROM usuarios 
                    WHERE 1=1";

    $params = [];
    $types  = "";

    // Filtro por nombre o email (búsqueda parcial)
    if ($busqueda !== null) {
        $sqlUsuarios .= " AND (nombre LIKE ? OR email LIKE ?)";
        $term = '%' . $busqueda . '%';
        $params[] = $term;
        $params[] = $term;
        $types   .= "ss";
    }

    // Filtro por Rol (alumno, profesor, admin)
    if ($rol !== null) {
        $sqlUsuarios .= " AND role = ?";
        $params[] = $rol;
        $types   .= "s";
    }

    // Filtro por Año de Nacimiento
    if ($anioNacimiento !== null) {
        $sqlUsuarios .= " AND YEAR(fecha_nacimiento) = ?";
        $params[] = $anioNacimiento;
        $types   .= "i";
    }

    $sqlUsuarios .= " ORDER BY nombre ASC";

    $stmt = $con->prepare($sqlUsuarios);

    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $res = $stmt->get_result();
    $usuarios = $res->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // Respuesta JSON
    echo json_encode([
        'status'   => 'success',
        'usuarios' => $usuarios
    ]);

} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        'status'  => 'error',
        'message' => 'Error en la base de datos: ' . $e->getMessage()
    ]);
    exit;
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status'  => 'error',
        'message' => $e->getMessage()
    ]);
    exit;
}