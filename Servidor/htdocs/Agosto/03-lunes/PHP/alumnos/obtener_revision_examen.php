<?php
session_start();
header('Content-Type: application/json');

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    if (!isset($_SESSION['logged']) || empty($_SESSION['logged'])) {
        throw new Exception('Sesión no iniciada.');
    }

    $alumno_id = $_SESSION['logged']['id'];
    $intento_id = isset($_GET['intento_id']) ? (int)$_GET['intento_id'] : 0;

    if ($intento_id <= 0) {
        throw new Exception('Intento no válido.');
    }

    require_once '../conexion.php';

    // 1. Datos del Alumno e Intento
    $sqlAlumno = "SELECT nombre AS nombre_completo 
                  FROM usuarios WHERE id = ?";
    $stmtU = $con->prepare($sqlAlumno);
    $stmtU->bind_param("i", $alumno_id);
    $stmtU->execute();
    $alumno = $stmtU->get_result()->fetch_assoc();
    $stmtU->close();

    // 2. Obtener SOLAMENTE las Preguntas asignadas a este intento y sus Respuestas
    $sqlPreguntas = "
        SELECT 
            p.id AS pregunta_id,
            p.enunciado,
            r.id AS respuesta_id,
            r.texto,
            r.es_correcta,
            IF(ra.respuesta_id IS NOT NULL, 1, 0) AS fue_marcada
        FROM intentos_examen ie
        INNER JOIN preguntas_intento pi ON pi.intento_id = ie.id
        INNER JOIN preguntas p ON p.id = pi.pregunta_id
        INNER JOIN respuestas r ON r.pregunta_id = p.id
        LEFT JOIN respuestas_alumno ra ON (ra.intento_id = ie.id AND ra.respuesta_id = r.id)
        WHERE ie.id = ? AND ie.alumno_id = ?
        ORDER BY pi.id ASC
    ";

    $stmtP = $con->prepare($sqlPreguntas);
    $stmtP->bind_param("ii", $intento_id, $alumno_id);
    $stmtP->execute();
    $resP = $stmtP->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmtP->close();

    // Agrupar respuestas por cada pregunta
    $preguntas = [];
    foreach ($resP as $row) {
        $pId = $row['pregunta_id'];
        if (!isset($preguntas[$pId])) {
            $preguntas[$pId] = [
                'id' => $pId,
                'enunciado' => $row['enunciado'],
                'respuestas' => []
            ];
        }
        $preguntas[$pId]['respuestas'][] = [
            'id' => $row['respuesta_id'],
            'texto' => $row['texto'],
            'es_correcta' => (bool)$row['es_correcta'],
            'fue_marcada' => (bool)$row['fue_marcada']
        ];
    }

    echo json_encode([
        'status' => 'success',
        'alumno' => $alumno,
        'preguntas' => array_values($preguntas)
    ]);

} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}