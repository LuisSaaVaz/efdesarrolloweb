<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

try {
    include 'conexion.php';

    $stmt = $con->prepare("SELECT id_bebida, nombre, precio, foto FROM bebidas ORDER BY nombre ASC");
    $stmt->execute();
    $result = $stmt->get_result();

    $bebidas = [];
    while ($row = $result->fetch_assoc()) {
        $bebidas[] = $row;
    }

    echo json_encode(['status' => 'success', 'bebidas' => $bebidas]);
    exit;

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    exit;
}
?>