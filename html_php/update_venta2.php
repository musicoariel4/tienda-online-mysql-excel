<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pedido_id           = $_POST['id'];
    $cliente_id          = $_POST['cliente_id'];
    $producto_id         = $_POST['producto_id'];
    $producto_id_antiguo = $_POST['producto_id_antiguo'];
    $cantidad            = (int)$_POST['cantidad'];
    $cantidad_antigua    = (int)$_POST['cantidad_antigua'];
    $fecha               = $_POST['fecha'];

    // 1. Validar que exista precio para el producto seleccionado a la fecha indicada
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

    if (!$resPrecio->fetch_assoc()) {
        die("❌ Error: No existe un precio registrado para este producto en la fecha seleccionada ($fecha).");
    }
    $stmtPrecio->close();

    // 2. Gestionar control de Stock
    if ($producto_id == $producto_id_antiguo) {
        // Mismo producto: Devolver stock anterior y calcular diferencia
        $stmtStock = $conexion->prepare("SELECT stock FROM productos WHERE id = ?");
        $stmtStock->bind_param("i", $producto_id);
        $stmtStock->execute();
        $stockActual = $stmtStock->get_result()->fetch_assoc()['stock'];
        $stmtStock->close();

        $stockDisponible = $stockActual + $cantidad_antigua;

        if ($cantidad > $stockDisponible) {
            die("❌ Error: La nueva cantidad ($cantidad) supera el stock disponible ($stockDisponible).");
        }

        // Nuevo stock
        $nuevoStock = $stockDisponible - $cantidad;
        $stmtUpStock = $conexion->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmtUpStock->bind_param("ii", $nuevoStock, $producto_id);
        $stmtUpStock->execute();
        $stmtUpStock->close();

    } else {
        // Producto diferente: Devolver stock al producto antiguo y verificar stock en el nuevo producto
        
        // Devolver al producto antiguo
        $stmtDev = $conexion->prepare("UPDATE productos SET stock = stock + ? WHERE id = ?");
        $stmtDev->bind_param("ii", $cantidad_antigua, $producto_id_antiguo);
        $stmtDev->execute();
        $stmtDev->close();

        // Verificar stock en el nuevo producto
        $stmtStock = $conexion->prepare("SELECT stock FROM productos WHERE id = ?");
        $stmtStock->bind_param("i", $producto_id);
        $stmtStock->execute();
        $stockNuevoProd = $stmtStock->get_result()->fetch_assoc()['stock'];
        $stmtStock->close();

        if ($cantidad > $stockNuevoProd) {
            die("❌ Error: No hay stock suficiente para el nuevo producto seleccionado.");
        }

        // Restar del nuevo producto
        $nuevoStock = $stockNuevoProd - $cantidad;
        $stmtRest = $conexion->prepare("UPDATE productos SET stock = ? WHERE id = ?");
        $stmtRest->bind_param("ii", $nuevoStock, $producto_id);
        $stmtRest->execute();
        $stmtRest->close();
    }

    // 3. Actualizar la tabla 'pedidos'
    $stmtPedido = $conexion->prepare("UPDATE pedidos SET cliente_id = ?, fecha = ? WHERE id = ?");
    $stmtPedido->bind_param("isi", $cliente_id, $fecha, $pedido_id);
    $stmtPedido->execute();
    $stmtPedido->close();

    // 4. Actualizar la tabla 'detalle_pedido'
    $stmtDetalle = $conexion->prepare("UPDATE detalle_pedido SET producto_id = ?, cantidad = ? WHERE pedido_id = ?");
    $stmtDetalle->bind_param("iii", $producto_id, $cantidad, $pedido_id);

    if ($stmtDetalle->execute()) {
        echo "<p style='color:green;'>✅ Venta #$pedido_id actualizada correctamente.</p>";
        echo "<p><a href='mostrar_ventas.php'>⬅ Volver al listado de ventas</a></p>";
    } else {
        echo "<p style='color:red;'>❌ Error al actualizar la venta: " . $stmtDetalle->error . "</p>";
    }

    $stmtDetalle->close();

} else {
    echo "<p>No se recibieron datos por POST.</p>";
}

$conexion->close();
?>