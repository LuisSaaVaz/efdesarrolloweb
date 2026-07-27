<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

try {
    include 'conexion.php';

    // Obtener todas las mesas ordenadas por su número
    $stmt = $con->prepare("SELECT id_mesa, numero_mesa, estado FROM mesas ORDER BY numero_mesa ASC");
    $stmt->execute();
    $result = $stmt->get_result();

    $mesas = [];
    while ($row = $result->fetch_assoc()) {
        $mesas[] = $row;
    }

    echo json_encode([
        'status' => 'success',
        'mesas'  => $mesas
    ]);
    exit;

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
?>