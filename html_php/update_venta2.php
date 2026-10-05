<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = (int)$_POST['id'];
$cliente_id = (int)$_POST['cliente_id'];
$producto_id = (int)$_POST['producto_id'];
$cantidad_nueva = (int)$_POST['cantidad'];
//$total = (float)$_POST['total'];
echo "ID de la venta: $id<br>";
echo "ID del cliente: $cliente_id<br>";
echo "ID del producto: $producto_id<br>";
echo "Cantidad nueva: $cantidad_nueva<br>";

// 1. Obtener datos de la venta actual
$sql = "SELECT producto_id, cantidad FROM detalle_pedido WHERE pedido_id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$venta_anterior = $resultado->fetch_assoc();
$stmt->close();

if (!$venta_anterior) {
    die("❌ Error: Venta no encontrada.");
}

$producto_anterior = (int)$venta_anterior['producto_id'];
$cantidad_anterior = (int)$venta_anterior['cantidad'];

// 2. Ajustar stock
if ($producto_id === $producto_anterior) {
    // Caso: mismo producto
    $diferencia = $cantidad_nueva - $cantidad_anterior;

    if ($diferencia > 0) {
        // Validar stock disponible
        $check = $conexion->query("SELECT stock FROM productos WHERE id = $producto_id");
        $row = $check->fetch_assoc();
        if ($row['stock'] < $diferencia) {
            die("❌ No hay stock suficiente. Disponible: {$row['stock']} unidades.");
        }
        $conexion->query("UPDATE productos SET stock = stock - $diferencia WHERE id = $producto_id");
    } elseif ($diferencia < 0) {
        $conexion->query("UPDATE productos SET stock = stock + " . abs($diferencia) . " WHERE id = $producto_id");
    }

} else {
    // Caso: cambió de producto
    // Restaurar stock al anterior
    $conexion->query("UPDATE productos SET stock = stock + $cantidad_anterior WHERE id = $producto_anterior");

    // Validar stock del nuevo
    $check = $conexion->query("SELECT stock FROM productos WHERE id = $producto_id");
    $row = $check->fetch_assoc();
    if ($row['stock'] < $cantidad_nueva) {
        die("❌ No hay stock suficiente en el nuevo producto. Disponible: {$row['stock']} unidades.");
    }
    // Restar al nuevo
    $conexion->query("UPDATE productos SET stock = stock - $cantidad_nueva WHERE id = $producto_id");
}

$sql = "SELECT precio FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $precioProducto = $fila['precio']; // ← aquí se guarda el precio
    echo "El precio del producto es: $" . $precioProducto*$_POST['cantidad'];
} else {
    echo "Producto no encontrado.";
}
    $total = $precioProducto*$_POST['cantidad'];

// 3. Actualizar la venta
$stmt_update = $conexion->prepare("UPDATE detalle_pedido SET producto_id = ?, cantidad = ? WHERE pedido_id  = ?");
$stmt_update->bind_param("iii", $producto_id, $cantidad_nueva, $id);    



if ($stmt_update->execute()) {
    echo "✅ Venta actualizada y stock ajustado correctamente.";
} else {
    echo "❌ Error al actualizar la venta: " . $conexion->error;
}

$stmt_update->close();
$conexion->close();
?>

<br><br>
<a href="mostrar_ventas.php">⬅️ Volver al listado de ventas</a>
