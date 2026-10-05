<<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_POST['id'];

// 1. Obtener los datos de la venta antes de eliminarla
$sql = "SELECT producto_id, cantidad FROM detalle_pedido WHERE pedido_id  = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$venta = $resultado->fetch_assoc();

if ($venta) {
    $producto_id = $venta['producto_id'];
    $cantidad = $venta['cantidad'];

    // 2. Restaurar el stock del producto
    $conexion->query("UPDATE productos SET stock = stock + $cantidad WHERE id = $producto_id");

    // 3. Eliminar la venta
    $sql_delete = "DELETE FROM detalle_pedido WHERE pedido_id = ?";
    $stmt_delete = $conexion->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id);
    
    if ($stmt_delete->execute()) {
        echo "✅ Venta eliminada y stock restaurado correctamente.";
    } else {
        echo "❌ Error al eliminar la venta: " . $conexion->error;
    }

    $stmt_delete->close();
} else {
    echo "❌ Error: Venta no encontrada.";
}

$stmt->close();
$conexion->close();
?>

<br><br>
<a href="mostrar_ventas.php">⬅️ Volver al listado de ventas</a>
