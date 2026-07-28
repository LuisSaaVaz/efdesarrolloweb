<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
header('Content-Type: application/json; charset=utf-8');

try {
    include 'conexion.php';

    $id_mesa = isset($_POST['id_mesa']) ? intval($_POST['id_mesa']) : 0;
    $email_cliente = isset($_POST['email']) ? trim($_POST['email']) : '';

    if ($id_mesa <= 0) {
        throw new Exception("ID de mesa no válido.");
    }
    
    // Obligatorio: debe existir y ser válido
    if (empty($email_cliente) || !filter_var($email_cliente, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("Es obligatorio proporcionar un e-mail válido para procesar el pago.");
    }

    // 1. Obtener el ticket pendiente de la mesa
    $sqlTicket = "SELECT id_ticket FROM tickets WHERE id_mesa = ? AND estado = 'pendiente' LIMIT 1";
    $stmtTicket = $con->prepare($sqlTicket);
    $stmtTicket->bind_param("i", $id_mesa);
    $stmtTicket->execute();
    $resTicket = $stmtTicket->get_result();

    if (!($rowTicket = $resTicket->fetch_assoc())) {
        throw new Exception("No hay ningún ticket pendiente para cobro en esta mesa.");
    }

    $id_ticket = $rowTicket['id_ticket'];

    // 2. Obtener el desglose de consumiciones para la tabla HTML y el cálculo del total
    $sqlBebidas = "SELECT b.nombre, tb.cantidad, tb.precio_unitario 
                   FROM ticket_bebidas tb 
                   INNER JOIN bebidas b ON tb.id_bebida = b.id_bebida 
                   WHERE tb.id_ticket = ?";
    $stmtBebidas = $con->prepare($sqlBebidas);
    $stmtBebidas->bind_param("i", $id_ticket);
    $stmtBebidas->execute();
    $resBebidas = $stmtBebidas->get_result();

    $filasTablaEmail = "";
    $totalPagar = 0;

    while ($item = $resBebidas->fetch_assoc()) {
        $subtotal = $item['cantidad'] * $item['precio_unitario'];
        $totalPagar += $subtotal;

        $filasTablaEmail .= "
            <tr>
                <td style='padding: 8px; border-bottom: 1px solid #ddd;'>{$item['nombre']}</td>
                <td style='padding: 8px; border-bottom: 1px solid #ddd; text-align: center;'>{$item['cantidad']}</td>
                <td style='padding: 8px; border-bottom: 1px solid #ddd; text-align: right;'>" . number_format($item['precio_unitario'], 2) . " €</td>
                <td style='padding: 8px; border-bottom: 1px solid #ddd; text-align: right;'>" . number_format($subtotal, 2) . " €</td>
            </tr>";
    }

    // 3. Cambiar el estado del ticket a 'pagado'
    $sqlUpdateTicket = "UPDATE tickets SET estado = 'pagado' WHERE id_ticket = ?";
    $stmtUpdateT = $con->prepare($sqlUpdateTicket);
    $stmtUpdateT->bind_param("i", $id_ticket);
    $stmtUpdateT->execute();

    // 4. Cambiar el estado de la mesa a 'libre'
    $sqlUpdateMesa = "UPDATE mesas SET estado = 'libre' WHERE id_mesa = ?";
    $stmtUpdateM = $con->prepare($sqlUpdateMesa);
    $stmtUpdateM->bind_param("i", $id_mesa);
    $stmtUpdateM->execute();

    // 5. Enviar e-mail de forma OBLIGATORIA
    $para = $email_cliente;
    $asunto = "Detalle de tu Ticket de Consumición";
    
    $mensaje = "
    <html>
    <head>
      <title>Resumen de Ticket</title>
    </head>
    <body style='font-family: Arial, sans-serif;'>
      <h2>¡Muchas gracias por tu visita!</h2>
      <p>Aquí tienes el desglose detallado de tu consumo:</p>
      <table style='width: 100%; max-width: 500px; border-collapse: collapse; margin-top: 15px;'>
        <thead>
          <tr style='background-color: #f2f2f2;'>
            <th style='padding: 8px; text-align: left;'>Producto</th>
            <th style='padding: 8px; text-align: center;'>Cant.</th>
            <th style='padding: 8px; text-align: right;'>Precio</th>
            <th style='padding: 8px; text-align: right;'>Total</th>
          </tr>
        </thead>
        <tbody>
          {$filasTablaEmail}
        </tbody>
      </table>
      <h3 style='margin-top: 15px;'>Total Pagado: " . number_format($totalPagar, 2) . " €</h3>
    </body>
    </html>";

    $cabeceras = "MIME-Version: 1.0\r\n";
    $cabeceras .= "Content-Type: text/html; charset=UTF-8\r\n";
    $cabeceras .= "From: admin@mail.com\r\n";

    // Intentar enviar el mail
    $envioCoreo = mail($para, $asunto, $mensaje, $cabeceras);

    if (!$envioCoreo) {
        throw new Exception("El pago se procesó, pero ocurrió un error al enviar el correo electrónico.");
    }

    echo json_encode([
        'status'  => 'success',
        'message' => 'Mesa pagada correctamente y ticket enviado por e-mail.'
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