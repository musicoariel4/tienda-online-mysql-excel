<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Capturar datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cliente_id  = $_POST['cliente_id'] ?? null;
    $producto_id = $_POST['producto_id'] ?? null;
    $cantidad    = $_POST['cantidad'] ?? 0;
    $fecha       = $_POST['fecha'] ?? date('Y-m-d');

    // 1. Consultar stock actual del producto (Usando Prepared Statement por seguridad)
    $stmtStock = $conexion->prepare("SELECT stock FROM productos WHERE id = ?");
    $stmtStock->bind_param("i", $producto_id);
    $stmtStock->execute();
    $resStock = $stmtStock->get_result();
    $producto = $resStock->fetch_assoc();
    $stmtStock->close();

    if (!$producto) {
        die("❌ Error: El producto no existe.");
    }

    // 2. Validar stock suficiente
    $stock_actual = $producto['stock'];
    if ($stock_actual == 0) {
        die("❌ Error: No hay stock disponible.");
    }
    if ($cantidad > $stock_actual) {
        die("❌ Error: La cantidad solicitada ($cantidad) es mayor al stock disponible ($stock_actual).");
    } 

    // 3. Consultar precio vigente en la tabla 'precio' a la fecha dada
    $sqlPrecio = "SELECT precio 
                  FROM precio 
                  WHERE producto_id = ? 
                    AND fecha_inicio <= ? 
                  ORDER BY fecha_inicio DESC 
                  LIMIT 1";

    $stmtPrecio = $conexion->prepare($sqlPrecio);
    $stmtPrecio->bind_param("is", $producto_id, $fecha);
    $stmtPrecio->execute();
    $resPrecio = $stmtPrecio->get_result();

    if ($filaPrecio = $resPrecio->fetch_assoc()) {
        $precioProducto = $filaPrecio['precio'];
        $total = $precioProducto * $cantidad;
    } else {
        die("❌ Error: No se encontró un precio registrado para este producto a la fecha ingresada ($fecha).");
    }
    $stmtPrecio->close();

    // 4. Insertar en la tabla 'pedidos'
    $sqlPedido = "INSERT INTO pedidos (cliente_id, fecha) VALUES (?, ?)";
    $stmtPedido = $conexion->prepare($sqlPedido);
    $stmtPedido->bind_param("is", $cliente_id, $fecha);
    $stmtPedido->execute();

    $pedido_id = $conexion->insert_id; // ID del pedido recién creado
    $stmtPedido->close();

    // 5. Insertar en 'detalle_pedido'
    $sqlDetalle = "INSERT INTO detalle_pedido (pedido_id, producto_id, cantidad) VALUES (?, ?, ?)";
    $stmtDetalle = $conexion->prepare($sqlDetalle);
    $stmtDetalle->bind_param("iii", $pedido_id, $producto_id, $cantidad);

    if ($stmtDetalle->execute()) {
        // 6. Actualizar el stock del producto
        $nuevo_stock = $stock_actual - $cantidad;
        $stmtUpdate = $conexion->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmtUpdate->bind_param("ii", $nuevo_stock, $producto_id);
        $stmtUpdate->execute();
        $stmtUpdate->close();

        echo "<p style='color:green;'>✅ Venta registrada exitosamente.</p>";
        echo "<p><strong>Detalle:</strong></p>";
        echo "<ul>";
        echo "<li><strong>Precio unitario:</strong> $" . number_format($precioProducto, 2) . "</li>";
        echo "<li><strong>Total:</strong> $" . number_format($total, 2) . "</li>";
        echo "<li><strong>Stock actualizado:</strong> $nuevo_stock unidades.</li>";
        echo "</ul>";
    } else {
        echo "<p style='color:red;'>❌ Error al insertar el detalle: " . $stmtDetalle->error . "</p>";
    }

    $stmtDetalle->close();

} else {
    echo "<p>No se recibieron datos por POST.</p>";
}

$conexion->close();
?>