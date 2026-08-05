<?php
session_start();
header('Content-Type: application/json');

// Configuración de reporte de errores mysqli
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // 1. Validar si existe la sesión 'logged'
    if (!isset($_SESSION['logged']) || empty($_SESSION['logged'])) {
        throw new Exception('Sesión no iniciada. Por favor, vuelve a ingresar.');
    }

    $usuario = $_SESSION['logged'];

    // 2. Validar que el rol sea alumno
    if ($usuario['role'] !== 'alumno') {
        throw new Exception('Acceso no autorizado: requiere rol de alumno.');
    }

    require_once '../conexion.php'; // Tu archivo donde se define $con

    $usuario_id = $usuario['id'];

    // 3. Asignaturas del Curso Actual (estado = 'cursando')
    $sqlActuales = "
        SELECT 
            a.id AS asignatura_id,
            a.nombre AS asignatura_nombre,
            c.nombre AS curso_nombre,
            aa.nombre AS ano_academico,
            uc.aula_id,
            uc.estado
        FROM usuarios_cursos uc
        INNER JOIN cursos c ON c.id = uc.curso_id
        INNER JOIN anos_academicos aa ON aa.id = uc.ano_academico_id
        INNER JOIN asignaturas a ON a.curso_id = c.id
        WHERE uc.usuario_id = ? AND uc.estado = 'cursando'
        ORDER BY a.nombre ASC
    ";

    $stmtActuales = $con->prepare($sqlActuales);
    $stmtActuales->bind_param("i", $usuario_id);
    $stmtActuales->execute();
    $resActuales = $stmtActuales->get_result();
    $actuales = $resActuales->fetch_all(MYSQLI_ASSOC);
    $stmtActuales->close();

    // 4. Asignaturas Pendientes de Años Anteriores
    $sqlPendientes = "
        SELECT DISTINCT
            a.id AS asignatura_id,
            a.nombre AS asignatura_nombre,
            c.nombre AS curso_nombre,
            aa.nombre AS ano_academico,
            uc.aula_id,
            'pendiente' AS estado
        FROM usuarios_cursos uc
        INNER JOIN cursos c ON c.id = uc.curso_id
        INNER JOIN anos_academicos aa ON aa.id = uc.ano_academico_id
        INNER JOIN asignaturas a ON a.curso_id = c.id
        WHERE uc.usuario_id = ? 
          AND uc.estado = 'superado'
          AND a.id NOT IN (
              SELECT ex.asignatura_id 
              FROM intentos_examen ie
              INNER JOIN examenes ex ON ex.id = ie.examen_id
              WHERE ie.alumno_id = ? AND ie.nota >= 5.00
          )
        ORDER BY a.nombre ASC
    ";

    $stmtPendientes = $con->prepare($sqlPendientes);
    $stmtPendientes->bind_param("ii", $usuario_id, $usuario_id);
    $stmtPendientes->execute();
    $resPendientes = $stmtPendientes->get_result();
    $pendientes = $resPendientes->fetch_all(MYSQLI_ASSOC);
    $stmtPendientes->close();

    // Respuesta exitosa
    echo json_encode([
        'status'     => 'success',
        'actuales'   => $actuales,
        'pendientes' => $pendientes
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
