<?php
$conexion = new mysqli("localhost", "root", "", "tienda_online");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$id = $_POST['id'];
$cliente_id = $_POST['cliente_id'];
$producto_id = $_POST['producto_id'];
$cantidad = $_POST['cantidad'];
//$total = $_POST['total'];

$sql = "SELECT precio FROM productos WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $producto_id);
$stmt->execute();
$resultado = $stmt->get_result();

if ($fila = $resultado->fetch_assoc()) {
    $precioProducto = $fila['precio']; // ← aquí se guarda el precio
    echo "El precio del producto es: $" . $precioProducto*$cantidad;
} else {
    echo "Producto no encontrado.";
}
    $total = $precioProducto*$cantidad;

// Actualizar la venta
$sql = "UPDATE ventas 
        SET cliente_id=?, producto_id=?, cantidad=?, total=? 
        WHERE id=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("iiidi", $cliente_id, $producto_id, $cantidad, $total, $id);

if ($stmt->execute()) {
    echo "✅ Venta actualizada correctamente.";
} else {
    echo "❌ Error al actualizar la venta: " . $conexion->error;
}

$stmt->close();
$conexion->close();
?>

<br><br>
<a href="mostrar_ventas.php">⬅️ Volver al listado de ventas</a>
