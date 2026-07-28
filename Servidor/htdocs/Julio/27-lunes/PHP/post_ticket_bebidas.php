<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

try {
    include 'conexion.php';

    $id_mesa = isset($_POST['id_mesa']) ? intval($_POST['id_mesa']) : 0;
    $bebidasRaw = isset($_POST['bebidas']) ? $_POST['bebidas'] : '[]';
    $pedido = json_decode($bebidasRaw, true);

    if ($id_mesa <= 0) {
        throw new Exception("ID de mesa no válido.");
    }

    if (!is_array($pedido)) {
        $pedido = [];
    }

    // 1. Buscar si la mesa ya tiene un ticket pendiente
    $sqlSelect = "SELECT id_ticket FROM tickets WHERE id_mesa = ? AND estado = 'pendiente' LIMIT 1";
    $stmtSelect = $con->prepare($sqlSelect);
    $stmtSelect->bind_param("i", $id_mesa);
    $stmtSelect->execute();
    $resSelect = $stmtSelect->get_result();

    $id_ticket = null;

    if ($row = $resSelect->fetch_assoc()) {
        $id_ticket = $row['id_ticket'];
    } else {
        // Si no hay ticket pendiente pero se han enviado consumiciones, creamos el ticket
        if (!empty($pedido)) {
            $sqlInsertTicket = "INSERT INTO tickets (id_mesa, estado, fecha) VALUES (?, 'pendiente', NOW())";
            $stmtTicket = $con->prepare($sqlInsertTicket);
            $stmtTicket->bind_param("i", $id_mesa);
            $stmtTicket->execute();
            $id_ticket = $con->insert_id;

            // Cambiamos el estado de la mesa a ocupada
            $sqlUpdateMesa = "UPDATE mesas SET estado = 'ocupada' WHERE id_mesa = ?";
            $stmtMesa = $con->prepare($sqlUpdateMesa);
            $stmtMesa->bind_param("i", $id_mesa);
            $stmtMesa->execute();
        }
    }

    // 2. Procesar las bebidas del ticket
    if ($id_ticket !== null) {
        $idsActualesEnPedido = [];

        foreach ($pedido as $item) {
            $id_bebida = intval($item['id_bebida']);
            $cantidad = intval($item['cantidad']);
            $precio = floatval($item['precio']);

            if ($cantidad > 0) {
                $idsActualesEnPedido[] = $id_bebida;

                // Gracias al UNIQUE(id_ticket, id_bebida), si la bebida ya existe, 
                // solo actualizamos la cantidad exacta enviada desde el modal
                $sqlUpsert = "INSERT INTO ticket_bebidas (id_ticket, id_bebida, cantidad, precio_unitario) 
                              VALUES (?, ?, ?, ?) 
                              ON DUPLICATE KEY UPDATE cantidad = VALUES(cantidad)";
                
                $stmtUpsert = $con->prepare($sqlUpsert);
                $stmtUpsert->bind_param("iiid", $id_ticket, $id_bebida, $cantidad, $precio);
                $stmtUpsert->execute();
            }
        }

        // 3. Limpieza de consumiciones retiradas o vaciado completo
        if (!empty($idsActualesEnPedido)) {
            // Eliminar solo las bebidas que el usuario ha borrado del ticket
            $inClause = implode(',', array_fill(0, count($idsActualesEnPedido), '?'));
            $types = str_repeat('i', count($idsActualesEnPedido) + 1);
            
            $sqlDelete = "DELETE FROM ticket_bebidas WHERE id_ticket = ? AND id_bebida NOT IN ($inClause)";
            $stmtDelete = $con->prepare($sqlDelete);
            
            $params = array_merge([$id_ticket], $idsActualesEnPedido);
            $stmtDelete->bind_param($types, ...$params);
            $stmtDelete->execute();

        } else {
            // SI EL TICKET SE QUEDA VACÍO:
            // a) Borrar consumiciones asociadas
            $sqlDeleteAll = "DELETE FROM ticket_bebidas WHERE id_ticket = ?";
            $stmtDeleteAll = $con->prepare($sqlDeleteAll);
            $stmtDeleteAll->bind_param("i", $id_ticket);
            $stmtDeleteAll->execute();

            // b) Eliminar el ticket pendiente
            $sqlDeleteTicket = "DELETE FROM tickets WHERE id_ticket = ?";
            $stmtDeleteTicket = $con->prepare($sqlDeleteTicket);
            $stmtDeleteTicket->bind_param("i", $id_ticket);
            $stmtDeleteTicket->execute();

            // c) Liberar la mesa
            $sqlUpdateMesaLibre = "UPDATE mesas SET estado = 'libre' WHERE id_mesa = ?";
            $stmtMesaLibre = $con->prepare($sqlUpdateMesaLibre);
            $stmtMesaLibre->bind_param("i", $id_mesa);
            $stmtMesaLibre->execute();
        }
    }

    echo json_encode([
        'status'  => 'success',
        'message' => 'Ticket de bebidas actualizado correctamente.'
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