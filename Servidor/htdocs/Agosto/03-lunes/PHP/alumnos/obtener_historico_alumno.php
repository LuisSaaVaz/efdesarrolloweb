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

    if ($usuario['role'] !== 'alumno') {
        throw new Exception('Acceso no autorizado: requiere rol de alumno.');
    }

    require_once '../conexion.php';

    $alumno_id = $usuario['id'];

    // Capturar filtros
    $ano_id    = isset($_GET['ano_id']) && $_GET['ano_id'] !== '' ? (int)$_GET['ano_id'] : null;
    $curso_id  = isset($_GET['curso_id']) && $_GET['curso_id'] !== '' ? (int)$_GET['curso_id'] : null;
    $asig_id   = isset($_GET['asig_id']) && $_GET['asig_id'] !== '' ? (int)$_GET['asig_id'] : null;
    $estado    = isset($_GET['estado']) && $_GET['estado'] !== '' ? trim($_GET['estado']) : null;
    $resultado = isset($_GET['resultado']) && $_GET['resultado'] !== '' ? trim($_GET['resultado']) : null;

    // --------------------------------------------------------------------------
    // A. OBTENER OPCIONES DINÁMICAS PARA LOS FILTROS
    // --------------------------------------------------------------------------

    // 1. Años académicos
    $sqlAnos = "SELECT DISTINCT aa.id, aa.nombre 
                FROM usuarios_cursos uc 
                INNER JOIN anos_academicos aa ON aa.id = uc.ano_academico_id 
                WHERE uc.usuario_id = ? 
                ORDER BY aa.nombre DESC";
    $stmt = $con->prepare($sqlAnos);
    $stmt->bind_param("i", $alumno_id);
    $stmt->execute();
    $anos = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // 2. Cursos (Filtrados si se ha seleccionado un Año)
    $sqlCursos = "SELECT DISTINCT c.id, c.nombre 
                  FROM usuarios_cursos uc 
                  INNER JOIN cursos c ON c.id = uc.curso_id 
                  WHERE uc.usuario_id = ?";
    $paramsC = [$alumno_id];
    $typesC  = "i";

    if ($ano_id !== null) {
        $sqlCursos .= " AND uc.ano_academico_id = ?";
        $paramsC[] = $ano_id;
        $typesC   .= "i";
    }

    $stmtC = $con->prepare($sqlCursos);
    $stmtC->bind_param($typesC, ...$paramsC);
    $stmtC->execute();
    $cursos = $stmtC->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmtC->close();

    // 3. Asignaturas (Incluyen el nombre del curso para agruparlas y responden a los filtros de Año/Curso)
    $sqlAsig = "SELECT DISTINCT a.id, a.nombre, c.nombre AS curso_nombre, c.id AS curso_id
                FROM usuarios_cursos uc 
                INNER JOIN asignaturas a ON a.curso_id = uc.curso_id 
                INNER JOIN cursos c ON c.id = a.curso_id
                WHERE uc.usuario_id = ?";
    $paramsA = [$alumno_id];
    $typesA  = "i";

    if ($ano_id !== null) {
        $sqlAsig .= " AND uc.ano_academico_id = ?";
        $paramsA[] = $ano_id;
        $typesA   .= "i";
    }
    if ($curso_id !== null) {
        $sqlAsig .= " AND uc.curso_id = ?";
        $paramsA[] = $curso_id;
        $typesA   .= "i";
    }
    
    // Ahora c.id sí forma parte del SELECT DISTINCT
    $sqlAsig .= " ORDER BY c.id ASC, a.nombre ASC";

    $stmtA = $con->prepare($sqlAsig);
    $stmtA->bind_param($typesA, ...$paramsA);
    $stmtA->execute();
    $asignaturas = $stmtA->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmtA->close();

    // --------------------------------------------------------------------------
    // B. CONSTRUIR CONSULTA DE HISTÓRICO CON FILTROS DINÁMICOS
    // --------------------------------------------------------------------------
    $sqlHistorico = "
        SELECT 
            ie.id AS intento_id,
            ie.nota,
            ie.tiempo_empleado_segundos,
            ie.estado,
            ie.fecha_inicio,
            ie.fecha_fin,
            ex.titulo AS examen_titulo,
            ex.duracion_minutos,
            a.nombre AS asignatura_nombre,
            c.nombre AS curso_nombre,
            aa.nombre AS ano_academico
        FROM intentos_examen ie
        INNER JOIN examenes ex ON ex.id = ie.examen_id
        INNER JOIN asignaturas a ON a.id = ex.asignatura_id
        INNER JOIN cursos c ON c.id = a.curso_id
        INNER JOIN anos_academicos aa ON aa.id = ie.ano_academico_id
        WHERE ie.alumno_id = ?
    ";

    $paramsH = [$alumno_id];
    $typesH  = "i";

    if ($ano_id !== null) {
        $sqlHistorico .= " AND ie.ano_academico_id = ?";
        $paramsH[] = $ano_id;
        $typesH   .= "i";
    }

    if ($curso_id !== null) {
        $sqlHistorico .= " AND c.id = ?";
        $paramsH[] = $curso_id;
        $typesH   .= "i";
    }

    if ($asig_id !== null) {
        $sqlHistorico .= " AND a.id = ?";
        $paramsH[] = $asig_id;
        $typesH   .= "i";
    }

    if ($estado !== null) {
        $sqlHistorico .= " AND ie.estado = ?";
        $paramsH[] = $estado;
        $typesH   .= "s";
    }

    if ($resultado === 'aprobado') {
        $sqlHistorico .= " AND ie.nota >= 5.00";
    } elseif ($resultado === 'suspenso') {
        $sqlHistorico .= " AND ie.nota < 5.00";
    }

    $sqlHistorico .= " ORDER BY ie.fecha_inicio DESC";

    $stmtH = $con->prepare($sqlHistorico);
    $stmtH->bind_param($typesH, ...$paramsH);
    $stmtH->execute();
    $resH = $stmtH->get_result();
    $historico = $resH->fetch_all(MYSQLI_ASSOC);
    $stmtH->close();

    // Respuesta JSON
    echo json_encode([
        'status'    => 'success',
        'filtros'   => [
            'anos'        => $anos,
            'cursos'      => $cursos,
            'asignaturas' => $asignaturas
        ],
        'historico' => $historico
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
