<?php
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    header('Content-Type: application/json; charset=utf-8');

    try {
        include 'conexion.php';

        $id_mesa = isset($_GET['id_mesa']) ? intval($_GET['id_mesa']) : 0;

        if ($id_mesa <= 0) {
            throw new Exception("ID de mesa inválido o no proporcionado.");
        }

        // 1. Buscar si la mesa está ocupada y tiene un ticket pendiente
        $sqlTicket = "SELECT id_ticket FROM tickets WHERE id_mesa = ? AND estado = 'pendiente' LIMIT 1";
        $stmt = $con->prepare($sqlTicket);
        $stmt->bind_param("i", $id_mesa);
        $stmt->execute();
        $resTicket = $stmt->get_result();

        $pedido = [];
        $id_ticket = null;
        $existe_ticket = false;

        // 2. Si existe un ticket pendiente para esta mesa
        if ($rowTicket = $resTicket->fetch_assoc()) {
            $id_ticket = $rowTicket['id_ticket'];
            $existe_ticket = true;

            // Obtener consumiciones leyendo precio_unitario guardado en el ticket
            $sqlBebidas = "SELECT tb.id_bebida, b.nombre, tb.precio_unitario AS precio, tb.cantidad 
                           FROM ticket_bebidas tb 
                           INNER JOIN bebidas b ON tb.id_bebida = b.id_bebida 
                           WHERE tb.id_ticket = ?";
            
            $stmtBebidas = $con->prepare($sqlBebidas);
            $stmtBebidas->bind_param("i", $id_ticket);
            $stmtBebidas->execute();
            $resBebidas = $stmtBebidas->get_result();

            while ($row = $resBebidas->fetch_assoc()) {
                $pedido[] = [
                    'id_bebida' => intval($row['id_bebida']),
                    'nombre'    => $row['nombre'],
                    'precio'    => floatval($row['precio']),
                    'cantidad'  => intval($row['cantidad'])
                ];
            }
        }

        echo json_encode([
            'status'        => 'success',
            'existe_ticket' => $existe_ticket,
            'id_ticket'     => $id_ticket,
            'pedido'        => $pedido
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